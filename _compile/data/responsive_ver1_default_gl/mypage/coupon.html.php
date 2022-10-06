<?php /* Template_ 2.2.6 2021/12/15 17:48:36 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/mypage/coupon.html 000020290 */  $this->include_("o2oFrontMypageCouponBarcode");
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 쿠폰 내역 @@
- 파일위치 : [스킨폴더]/mypage/coupon.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if($TPL_VAR["checkO2OService"]){?>
<?php $this->print_("o2o_mypage_coupon_init",$TPL_SCP,1);?>

<?php }?>

<div class="subpage_wrap">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"><!-- [스킨폴더]/mypage/mypage_lnb.html --></div>
	<!-- +++++ //mypage LNB ++++ -->

	<!-- +++++ mypage contents ++++ -->
	<div class="subpage_container">
		<!-- 전체 메뉴 -->
		<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)">MENU</a>

		<!-- 타이틀 -->
		<div class="title_container">
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbXlwYWdlL2NvdXBvbi5odG1s" >쿠폰 내역</span></h2>
		</div>

		<!-- 탭 -->
		<div class="tab_basic size2">
			<ul>
				<li <?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>class="on"<?php }?>>
					<a href="/mypage/coupon?tab=1"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbXlwYWdlL2NvdXBvbi5odG1s" >보유한 쿠폰</span>(<strong class="pointcolor2"><?php echo number_format($TPL_VAR["unusedcount"])?></strong>/<?php echo number_format($TPL_VAR["totalcount"])?>)</a>
				</li>
				<li <?php if($_GET["tab"]=='2'){?>class="on"<?php }?>>
					<a href="/mypage/coupon?tab=2"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbXlwYWdlL2NvdXBvbi5odG1s" >다운로드 가능 쿠폰</span>(<?php echo number_format($TPL_VAR["svcount"])?>)</a>
				</li>
			</ul>
		</div>
		
		<div class="Clearfix">
			<ul class="tab_right_menu">
				<li>
					<a class="btn_resp size_b" href="/mypage/offlinecoupon">+ 쿠폰 등록</a>
				</li>
			</ul>

			<!-- 검색 -->
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
			<div class="search_open Fr">
				<button type="button" id="btnSearchOpen" class="btn_resp size_b">상세 검색 ↓</button>
			</div>
			<form name="couponsearch" id="couponsearch" >
			<input type="hidden" name="perpage" id="perpage" value="<?php echo $_GET["perpage"]?>" >
			<input type="hidden" name="page" id="page" value="<?php echo $_GET["page"]?>" >
			<input type="hidden" name="orderby" id="orderby" value="<?php echo $_GET["orderby"]?>" >
			<input type="hidden" name="sdate" id="sdate" value="<?php echo $_GET["sdate"]?>" />
			<input type="hidden" name="edate" id="edate" value="<?php echo $_GET["edate"]?>" />
			<div class="Relative">
				<div id="searchCouponForm" class="search_basic v2" style="display:none;">
					<div class="search_basic_area">
						<ul>
							<li class="th">쿠폰명</li>
							<li class="td"><input type="text" name="keyword" id="keyword" value="<?php echo $_GET["keyword"]?>" title="쿠폰명" /></li>
						</ul>
						<ul>
							<li class="th">
								<select name="check_date">
									<option value="regist_date" <?php if($_GET["check_date"]=='regist_date'){?>selected<?php }?>>발급일</option>
									<option value="use_date" <?php if($_GET["check_date"]=='use_date'){?>selected<?php }?>>사용일</option>
								</select>
							</li>
							<li class="td">
								<select name="couponDateSelect" class="min_width1">
									<option value="today" <?php if($_GET["couponDateSelect"]=='today'){?>selected<?php }?>>오늘</option>
									<option value="3day" <?php if($_GET["couponDateSelect"]=='3day'){?>selected<?php }?>>3일간</option>
									<option value="1week" <?php if($_GET["couponDateSelect"]=='1week'){?>selected<?php }?>>일주일</option>
									<option value="1month" <?php if($_GET["couponDateSelect"]=='1month'){?>selected<?php }?>>1개월</option>
									<option value="3month" <?php if($_GET["couponDateSelect"]=='3month'){?>selected<?php }?>>3개월</option>
									<option value="all" <?php if($_GET["couponDateSelect"]=='all'||$_GET["couponDateSelect"]==''){?>selected<?php }?>>전체</option>
								</select>
							</li>
						</ul>
						<ul>
							<li class="th">사용여부</li>
							<li class="td">
								<label><input type="checkbox" name="couponUsed[]" id="couponUsed1" value="used" <?php if($_GET["couponUsed"]&&in_array('used',$_GET["couponUsed"])){?>checked<?php }?>/> 사용</label> &nbsp;
								<label><input type="checkbox" name="couponUsed[]"  id="couponUsed2" value="unused" <?php if($_GET["couponUsed"]&&in_array('unused',$_GET["couponUsed"])){?>checked<?php }?> /> 미사용</label> &nbsp;
								<button type="button" class="all-check btn_resp">전체</button>
							</li>
						</ul>
						<ul>
							<li class="th">유효기간</li>
							<li class="td">
								<label><input type="checkbox" name="couponDate[]"  id="couponDate1" value="available" <?php if($_GET["couponDate"]&&in_array('available',$_GET["couponDate"])){?>checked<?php }?> /> 유효</label> &nbsp;
								<label><input type="checkbox" name="couponDate[]"  id="couponDate2" value="extinc" <?php if($_GET["couponDate"]&&in_array('extinc',$_GET["couponDate"])){?>checked<?php }?> /> 소멸</label> &nbsp;
								<button type="button" class="all-check btn_resp">전체</button>
							</li>
						</ul>
					</div>
					<div class="search_btn_area">
						<button type="submit" class="btn_resp size_b color6">검색</button>
					</div>
				</div>
			</div>
			</form>
<?php }?>
			<!-- //검색 -->
		</div>


<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
<?php if($TPL_VAR["loop"]){?>
		<div class="res_table mt10 ">
			<ul class="thead">
				<li style="width:17%;">쿠폰명</li>
				<li>혜택</li>
				<li style="width:70px;">발급일</li>
				<li style="width:90px;">유효기간</li>
				<li style="width:80px;">남은 일자</li>
				<li style="width:100px;">제한 금액</li>
				<li style="width:60px;">상태</li>
				<li style="width:60px;">적용대상</li>
			</ul>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
<?php if($TPL_V1["use_type"]=='offline'&&$TPL_V1["use_status"]=='unused'){?>
			<ul class="tbody offline_use hand coupon_<?php echo $TPL_V1["use_status"]?>" coupon_seq="<?php echo $TPL_V1["coupon_seq"]?>" download_seq="<?php echo $TPL_V1["download_seq"]?>">
<?php }else{?>
			<ul class="tbody coupon_<?php echo $TPL_V1["use_status"]?>">
<?php }?>
				<li class="L sjb_top grow gray_01" style="order:-10;"><?php echo $TPL_V1["cp_name"]?></li>
				<li class="subject">
					
					<!-- O2O 쿠폰 표시 -->
<?php if(($TPL_VAR["ISMOBILE_AGENT"])){?>
					<?php echo o2oFrontMypageCouponBarcode($TPL_V1)?>

<?php }?>
					<!-- //O2O 쿠폰 표시 -->

					<span class="pointcolor2"><?php echo $TPL_V1["salepricetitle"]?></span>
				</li>
				<li class="sjb_top mo_r" style="order:-9;"><span class="motle">발급일:</span> <?php echo $TPL_V1["date"]?></li>
				<li>
<?php if(($TPL_V1["type"]=='offline_emoney'||$TPL_V1["use_type"]=='offline')){?>
					-
<?php }else{?>
					~<?php echo date('Y.m.d',strtotime($TPL_V1["issue_enddate"]))?>

<?php }?>
				</li>
				<li><span class="pointcolor2"><?php echo $TPL_V1["issuedaylimit"]?></span></li>
				<li>
<?php if(($TPL_V1["type"]=='offline_emoney'||$TPL_V1["use_type"]=='offline')){?>
					-
<?php }else{?>
					<?php echo $TPL_V1["limit_price"]?>

<?php }?>
				</li>
				<li class="sjb_top mo_r" style="order:-8;"><span class="pointcolor2"><?php echo $TPL_V1["use_status_title"]?></span></li>
				<li class="grow mo_r">
<?php if($TPL_V1["type"]=='offline_emoney'){?>
					-
<?php }else{?>
					<button type="button" class="coupongoodsreviewbtn btn_resp mo_adj" coupon_type="<?php if($TPL_V1["type"]=='offline_coupon'){?>offline<?php }else{?>online<?php }?>" coupon_seq="<?php echo $TPL_V1["coupon_seq"]?>" download_seq="<?php echo $TPL_V1["download_seq"]?>"  use_type="<?php echo $TPL_V1["use_type"]?>" issue_type="<?php echo $TPL_V1["issue_type"]?>" coupon_name="<?php echo $TPL_V1["coupon_name"]?>">조회</button>
<?php }?>
				</li>
			</ul>
<?php }}?>
		</div>
		<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
<?php }else{?>
		<div class="no_data_area2">
			보유한 쿠폰이 없습니다.
		</div>
<?php }?>

<?php }else{?>
<?php if($TPL_VAR["loop"]){?>
		<div class="res_table mt10">
			<ul class="thead">
				<li>쿠폰명 / 종류</li>
				<li>할인액(율)</li>
				<li style="width:130px;">유효기간</li>
				<li style="width:100px;">제한금액</li>
				<!--li style="width:120px;">다운로드 가능기간<br/>/포인트 전환 조건</li-->
				<li style="width:60px;">적용대상</li>
				<li style="width:80px;">다운로드</li>
			</ul>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<ul class="tbody">
				<li class="L sjb_top" style="order:-10;"><strong class="gray_01"><?php echo $TPL_V1["coupon_name"]?></strong> <span class="Dib">/ <?php echo $TPL_V1["issuebtn"]?></span></li>
				<li class="subject"><span class="pointcolor2"><?php echo $TPL_V1["salepricetitle"]?></span></li>
				<li><span class="pointcolor2"><?php echo $TPL_V1["downloaddate"]?></span></li>
				<li>
<?php if($TPL_V1["use_type"]=='offline'){?>
					-
<?php }else{?>
					<?php echo $TPL_V1["limit_price"]?>

<?php }?>
				</li>
				<!--li><?php echo $TPL_V1["downdate"]?></li-->
				<li class="sjb_top mo_r grow" style="order:-9;">
<?php if($TPL_V1["type"]!='offline_emoney'){?>
					<button type="button" class="coupongoodsreviewbtn btn_resp mo_adj" coupon_type="<?php if($TPL_V1["type"]=='offline_coupon'){?>offline<?php }else{?>online<?php }?>" coupon_seq="<?php echo $TPL_V1["coupon_seq"]?>" download_seq="<?php echo $TPL_V1["download_seq"]?>" use_type="<?php echo $TPL_V1["use_type"]?>" issue_type="<?php echo $TPL_V1["issue_type"]?>" coupon_name="<?php echo $TPL_V1["coupon_name"]?>">조회</button>
<?php }?>
				</li>
				<li class="grow mo_r">
<?php if($TPL_V1["downckbtn"]){?>
						<button type="button" class="downloadbtn btn_resp color2 mo_adj" coupon_type="<?php echo $TPL_V1["type"]?>" coupon_seq="<?php echo $TPL_V1["coupon_seq"]?>" coupon_name="<?php echo $TPL_V1["coupon_name"]?>" coupon_point="<?php echo $TPL_V1["coupon_point"]?>">쿠폰받기</button>
<?php }else{?>
						&nbsp;
<?php }?>
				</li>
			</ul>
<?php }}?>
		</div>
		<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
<?php }else{?>
		<div class="no_data_area2">
			다운로드 가능한 쿠폰이 없습니다.
		</div>
<?php }?>
<?php }?>



	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_ver1_default_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->


<!-- 쿠폰 직원 사용 -->
<div id="couponuse_area" class="resp_layer_pop hide">
	<h4 class="title">쿠폰 사용하기</h4>
	<div class="y_scroll_auto">
		<div class="layer_pop_contents v3">
			<h5 class="stitle">직원코드를 입력해 주세요.</h5>
			<form name="confirmuserForm" id="confirmuserForm" method="post" action="../mypage_process/usemycoupon" target="actionFrame" >
			<input type="hidden" name="download_seq" id="download_seq" value="" />
			<div class="ibox">
				<input type="text" name="manager_code" id="manager_code" class="use_input" title="직원코드를 입력해 주세요" />
				<button type="submit" id="BoardPwcheckBtn" class="btn_resp size_b color6">확인</button>
				<!--button type="button" class="btn_resp size_b" onclick="$('#manager_code').val(''); hideCenterLayer();">취소</button-->
			</div>
			</form>
		</div>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="$('#manager_code').val(''); hideCenterLayer()"></a>
</div>

<!-- ? -->
<div id="showList" class="hide"> </div>

<!-- 쿠폰 정보 -->
<div id="couponTargetLayer" class="resp_layer_pop hide">
	<h4 class="title">쿠폰 정보</h4>
	<div class="y_scroll_auto">
		<div class="layer_pop_contents v3">
		</div>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
</div>

<?php if($_GET["tab"]!='2'){?>
<script type="text/javascript" src="/app/javascript/plugin/validate/jquery.validate.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" ></script>
<?php }?>

<script type="text/javascript">
	/* input form style 적용*/
	function apply_input_style(){
		$('img.small_goods_image').each(function() {
			if (!this.complete ) {// image was broken, replace with your new image
				this.src = '/data/icon/error/noimage_list.gif';
			}
		});
	}

	$(document).ready(function() {
		/* 스타일적용 */
		apply_input_style();

<?php if($_GET["tab"]=='2'){?>
			//쿠폰받기
			$(".downloadbtn").live("click",function(){
				var mypoint = <?php if($TPL_VAR["mypoint"]){?><?php echo $TPL_VAR["mypoint"]?><?php }else{?>0<?php }?>;
				var coupon_type = $(this).attr('coupon_type');
				var coupon_seq = $(this).attr('coupon_seq');
				var coupon_name = $(this).attr('coupon_name');
				var coupon_point = $(this).attr('coupon_point');
				if( coupon_type == 'point' && (mypoint < coupon_point || mypoint < 1) ){//전환포인트인경우
					if(mypoint < 1){
						//보유포인트가 없습니다.
						openDialogAlert(getAlert('mp178'),'400','140',function(){});
					}else{
						//전환포인트 금액이 보유포인트보다 작습니다.
						openDialogAlert(getAlert('mp179'),'400','140',function(){});
					}
					return false;
				}else{
					//쿠폰을 다운받으시겠습니까?
					openDialogConfirm("["+coupon_name+"] "+getAlert('mp046'),400,140,function(){
						$.ajax({
							'url' : '../coupon/download_member',
							'data' : {'coupon_seq':coupon_seq},
							'type' : 'post',
							'dataType': 'json',
							'success': function(data) {
								if(data.result){
									openDialogAlert(data.msg,'400','140',function(){document.location.reload();});
								}else{
									openDialogAlert(data.msg,'400','140',function(){});
								}
							}
						});
					},function(){});
				}
			});
<?php }else{?>
<?php }?>
	});

	$(document).ready(function() {
		setDefaultText();
		$(".all-check").toggle(function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',true);
		},function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',false);
		});

		// 쿠폰사용가능한 상품 조회하기 (적용대상조회)
		$('.coupongoodsreviewbtn').click(function() {
			var coupon_type = $(this).attr("coupon_type");
			var use_type = $(this).attr("use_type");
			var issue_type = $(this).attr("issue_type");
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
				var download_seq = $(this).attr("download_seq");
				var coupon_seq = $(this).attr("coupon_seq");
				var coupongoodsreviewerurl = '../coupon/coupongoodsreviewer?no='+download_seq+'&coupon_type='+coupon_type+'&coupon_seq='+coupon_seq+'&download_seq='+download_seq;
<?php }else{?>
				var coupon_seq = $(this).attr("coupon_seq");
				var coupongoodsreviewerurl = '../coupon/coupongoodsreviewer?no='+coupon_seq+'&coupon_type='+coupon_type;
<?php }?>

			$.get(coupongoodsreviewerurl, {}, function(data) {
				$('#couponTargetLayer .layer_pop_contents').html(data);
				showCenterLayer('#couponTargetLayer');
			});
			//var coupon_name = $(this).attr("coupon_name");
			/*
			if( use_type == 'offline' ) {
				addFormDialog(coupongoodsreviewerurl, '650', '', getAlert('mp093'),'false');
			}else{
				addFormDialog(coupongoodsreviewerurl, '450', '', getAlert('mp093'),'false');
			}
			*/
			return false;
		});

		//상품 조회후 상품검색창
		$("input:button[name=goodssearchbtn]").live("click",function(){
			var goods_seq		= $("#coupongoods_goods_seq").val();
			var coupon_seq	= $(this).attr("coupon_seq");

			if(!goods_seq) {
				//상품번호를 정확히 입력해 주세요.
				openDialogAlert(getAlert('mp090'),'260','140',function(){$("#coupongoods_goods_seq").focus();return;});
			}else{
				$.ajax({
					'url' : '../coupon/coupongoodssearch',
					'data' : {'coupon':coupon_seq,'goods':goods_seq},
					'type' : 'post',
					'dataType': 'json',
					'success' : function(res){
						$(".coupongoodsreviewerno").hide();//상품사용불가
						$(".coupongoodsrevieweryes").hide();//쿠폰사용가능
						if( res.result == 'goodsyes' ) {
							var imgsrc = (eval("res.goods.src"))?res.goods.src:"/admin/skin/default/images/common/noimage_list.gif";
							$(".coupongoodsrevieweryes").show();
							$(".coupongoodsrevieweryes .issueGoods").find(".image").html("<img class=\"goodsThumbView\"  alt=\"\" src=\""+imgsrc+"\" width=\"50\" height=\"50\">");
							$(".coupongoodsrevieweryes .issueGoods").find(".name").html(res.goods.name);
							$(".coupongoodsrevieweryes .issueGoods").find(".price").html(res.goods.price);
							$(".coupongoodsrevieweryes .issueGoods").attr("goods_seq",goods_seq);

							//상품번호 찾기
							openDialog(getAlert('mp091'),"coupongoodsreviewerpopup",{"width":"480","height":"280"});
						}else if( res.result == 'goodsno' ) {
							var imgsrc = (eval("res.goods.src"))?res.goods.src:"/admin/skin/default/images/common/noimage_list.gif";
							$(".coupongoodsreviewerno").show();
							$(".coupongoodsrevieweryes .issueGoods").find(".image").html("<img class=\"goodsThumbView\"  alt=\"\" src=\""+imgsrc+"\" width=\"50\" height=\"50\">");
							$(".coupongoodsrevieweryes .issueGoods").find(".name").html(res.goods.name);
							$(".coupongoodsrevieweryes .issueGoods").find(".price").html(res.goods.price);
							$(".coupongoodsrevieweryes .issueGoods").attr("goods_seq",goods_seq);

							openDialog(getAlert('mp091'),"coupongoodsreviewerpopup",{"width":"400","height":"250"});
						}else{
							//상품을 찾을 수 없습니다.<br/>확인 후 다시 입력하시기 바랍니다.
							openDialogAlert(getAlert('mp092'),'250','160');
						}
					}
				});
			}
		});

		//상품상세보기
		$('.coupongoodsdetail').live("click",function(){
			window.open("/goods/view?no="+$(".coupongoodsrevieweryes .issueGoods").attr("goods_seq"),'','');
		});

		$('[name=couponDateSelect]').on('change', function() {
			switch( $(this).val() ) {
				case 'today' :
					$("input[name='sdate']").val(getDate(0));
					$("input[name='edate']").val(getDate(0));
					break;
				case '3day' :
					$("input[name='sdate']").val(getDate(3));
					$("input[name='edate']").val(getDate(0));
					break;
				case '1week' :
					$("input[name='sdate']").val(getDate(7));
					$("input[name='edate']").val(getDate(0));
					break;
				case '1month' :
					$("input[name='sdate']").val(getDate(30));
					$("input[name='edate']").val(getDate(0));
					break;
				case '3month' :
					$("input[name='sdate']").val(getDate(90));
					$("input[name='edate']").val(getDate(0));
					break;
				default :
					$("input[name='sdate']").val('');
					$("input[name='edate']").val('');
					break;
			}
		});

		$(".offline_use").click(function (){
			$("#download_seq").val($(this).attr('download_seq'));
			//쿠폰사용하기
			showCenterLayer('#couponuse_area');
			//openDialog("<span class='desc'>"+getAlert('mp136')+"</span>", "couponuse_area", {"width":"370","height":"200"});
		});

		$('#btnSearchOpen').on('click', function() {
			if ( $('#searchCouponForm').is(':hidden') ) {
				$('#searchCouponForm').show();
				$(this).text('상세 검색 ↑');
			} else {
				$('#searchCouponForm').hide();
				$(this).text('상세 검색 ↓');
			}
		});
<?php if($_GET["check_date"]){?>
			$('#btnSearchOpen').click();
<?php }?>
	});

	function issue_list(coupon_seq){
		window.open('/popup/issue_list?coupon_seq='+coupon_seq+'','issue_list','width=500,height=350');
	}
</script>