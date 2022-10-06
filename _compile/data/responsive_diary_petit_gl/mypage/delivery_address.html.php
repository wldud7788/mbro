<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/mypage/delivery_address.html 000033200 */ 
$TPL_arr_address_group_1=empty($TPL_VAR["arr_address_group"])||!is_array($TPL_VAR["arr_address_group"])?0:count($TPL_VAR["arr_address_group"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL_ship_gl_arr_1=empty($TPL_VAR["ship_gl_arr"])||!is_array($TPL_VAR["ship_gl_arr"])?0:count($TPL_VAR["ship_gl_arr"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 배송 주소록 @@
- 파일위치 : [스킨폴더]/mypage/delivery_address.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

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
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvZGVsaXZlcnlfYWRkcmVzcy5odG1s" >주소록</span></h2>
		</div>

		<div id="wrapper">
			<div class="address_reg">
				<form name="addressBookFrm">
					<input type="hidden" name="tab" value="<?php echo $_GET["tab"]?>" />
					<input type="hidden" name="popup" value="<?php echo $_GET["popup"]?>" />

					<!-- 탭 -->
					<div class="tab_basic size1">
						<ul>
							<li <?php if($_GET["tab"]=='1'||!$_GET["tab"]){?> class="on"<?php }?>>
								<a href="javascript:;" onclick="submitAddressBookFrm('tab','1')"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvZGVsaXZlcnlfYWRkcmVzcy5odG1s" >자주쓰는 배송지</span></a>
							</li>
							<li <?php if($_GET["tab"]=='2'){?> class="on"<?php }?>>
								<a href="javascript:;" onclick="submitAddressBookFrm('tab','2')"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvZGVsaXZlcnlfYWRkcmVzcy5odG1s" >최근 배송지</span></a>
							</li>
						</ul>
					</div>

<?php if($_GET["popup"]){?>
					아직 확인하지 못한 영역<br />
					<span class="desc pdr5">최대 30개까지 보여집니다.</span>
					<a href="javascript:;" class="pop_close" onclick="self.close();">창닫기</a>
<?php }?>

					<ul class="sorting_group right_static">
						<li class="left_area">
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
							<select name="group" onchange="submitAddressBookFrm()">
								<option value="" <?php if($_GET["group"]==''){?>selected<?php }?>>전체 그룹</option>
<?php if($TPL_arr_address_group_1){foreach($TPL_VAR["arr_address_group"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["address_group"]?>" <?php if($_GET["group"]==$TPL_V1["address_group"]){?>selected<?php }?>><?php echo $TPL_V1["address_group"]?></option>
<?php }}?>
							</select>
<?php }?>
							<select name="view_international" onchange="submitAddressBookFrm()">
								<option value="" <?php if($_GET["view_international"]==''){?>selected<?php }?>>국내/해외</option>
								<option value="domestic" <?php if($_GET["view_international"]=='domestic'){?>selected<?php }?>>국내</option>
								<option value="international" <?php if($_GET["view_international"]=='international'){?>selected<?php }?>>해외</option>
							</select>
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
<?php }else{?>
							<select class="custom-select-box-multi" name="order" onchange="submitAddressBookFrm()">
								<option value="ads" <?php if($_GET["order"]=='ads'||!$_GET["order"]){?>selected<?php }?>>최근등록순</option>
								<option value="name_dn" <?php if($_GET["order"]=='name_dn'){?>selected<?php }?>>받는분 ↓</option>
								<option value="name_up" <?php if($_GET["order"]=='name_up'){?>selected<?php }?>>받는분 ↑</option>
							</select>
<?php }?>
						</li>
					</ul>
				</form>

<?php if($TPL_VAR["loop"]){?>
				<div class="res_table">
					<ul class="thead">
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
						<li style="width:80px;">그룹</li>
<?php }?>
						<li style="width:65px;">국내/해외</li>
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
						<li style="width:80px;">배송지설명 </li>
<?php }?>
						<li style="width:74px;">받는분</li>
						<li>주소</li>
						<li style="width:105px;">연락처</li>
						<li <?php if($_GET["tab"]=='1'||!$_GET["tab"]){?> class="manage" <?php }else{?> class="manage2" <?php }?>>관리</li>
					</ul>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
					<ul class="tbody <?php if($TPL_V1["default"]=='Y'){?>basic_addr<?php }?>">
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
						<li><span class="mo_stle"><?php echo $TPL_V1["address_group"]?></span></li>
<?php }?>
<?php if($TPL_V1["international"]=='domestic'){?>
						<li class="sjb_top grow mo_r" style="order:-8;"><?php echo $TPL_V1["international_show"]?></li>
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
						<li><span class="motle">설명:</span> <?php echo $TPL_V1["address_description"]?></li>
<?php }?>
						<li class="sjb_top" style="order:-10;"><span class="motle">받는분:</span> <strong class="pointcolor"><?php echo $TPL_V1["recipient_user_name"]?></strong></li>
						<li class="addressResult subject" seq="<?php echo $TPL_V1["address_seq"]?>">
<?php if($_GET["popup"]){?><span style="cursor:pointer;"><?php }?>
								[<?php echo $TPL_V1["recipient_zipcode"]?>]
<?php if($TPL_V1["recipient_address_type"]=="street"){?> <?php echo $TPL_V1["recipient_address_street"]?> <?php }else{?> <?php echo $TPL_V1["recipient_address"]?> <?php }?> <?php echo $TPL_V1["recipient_address_detail"]?>

<?php if($TPL_V1["default"]=='Y'){?><img src="/data/skin/responsive_diary_petit_gl/images/common/icon_default.gif" title="기본" /><?php }?>
<?php if($_GET["popup"]){?></span><?php }?>
						</li>
						<li class="sjb_top grow" style="order:-9;">
							<span class="Dib"><?php echo $TPL_V1["recipient_cellphone"]?></span>
							<span class="Dib"><span class="mo_show">/</span> <?php echo $TPL_V1["recipient_phone"]?></span>
						</li>
						<li class="grow mo_r">
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
							<button type="button" class="updateaddress btn_resp mo_adj" seq="<?php echo $TPL_V1["address_seq"]?>">수정</button>
<?php }else{?>
							<button type="button" class="btn_resp color4 mo_adj" onclick="change_address_btn(<?php echo $TPL_V1["address_seq"]?>)">자주쓰는 배송지로 등록</button>
<?php }?>
							<button type="button" class="btn_resp mo_adj" onclick="delete_address_btn(<?php echo $TPL_V1["address_seq"]?>)">삭제</button>
						</li>
<?php }else{?>
						<li class="sjb_top grow mo_r" style="order:-8;"><?php echo $TPL_V1["international_show"]?></li>
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
						<li><span class="motle">설명:</span> <?php echo $TPL_V1["address_description"]?></li>
<?php }?>
						<li class="sjb_top" style="order:-10;"><span class="motle">받는분:</span> <strong class="pointcolor2"><?php echo $TPL_V1["recipient_user_name"]?></strong></li>
						<li class="addressResult subject" seq="<?php echo $TPL_V1["address_seq"]?>">
<?php if($_GET["popup"]){?><span style="cursor:pointer;"><?php }?>
<?php if($TPL_V1["nation"]){?><span class="pointcolor">[<?php echo $TPL_V1["nation"]?>]</span><?php }?>
								<?php echo $TPL_V1["international_address"]?>, <?php echo $TPL_V1["international_town_city"]?>, <?php echo $TPL_V1["international_county"]?>, <?php echo $TPL_V1["international_postcode"]?>,<?php echo $TPL_V1["international_country"]?>

<?php if($_GET["popup"]){?></span><?php }?>
						</li>
						<li class="sjb_top grow" style="order:-9;">
							<span class="Dib"><?php echo $TPL_V1["recipient_cellphone"]?></span>
							<span class="Dib"><span class="mo_show">/</span> <?php echo $TPL_V1["recipient_phone"]?></span> 
						</li>
						<li class="grow mo_r">
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
							<button type="button" class="updateaddress btn_resp mo_adj" seq="<?php echo $TPL_V1["address_seq"]?>">수정</button>
<?php }else{?>
							<button type="button" class="btn_resp color4 mo_adj" onclick="change_address_btn(<?php echo $TPL_V1["address_seq"]?>)">자주쓰는 배송지로 등록</button>
<?php }?>
							<button type="button" class="btn_resp mo_adj" onclick="delete_address_btn(<?php echo $TPL_V1["address_seq"]?>)">삭제</button>
						</li>
<?php }?>
					</ul>
<?php }}?>
				</div>
<?php }else{?>
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
				<div class="no_data_area2">
					등록하신 자주쓰는 배송지가 없습니다.
				</div>
<?php }elseif($_GET["tab"]=='2'){?>
				<div class="no_data_area2">
					최근 배송지가 없습니다.
				</div>
<?php }?>
<?php }?>

<?php if($TPL_VAR["page"]["totalpage"]> 1){?>
				<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>
<?php }?>

<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
				<ul class="bbs_bottom_wrap">
					<li class="right">
						<span class="add_address">
							<button type="button" class="addAddress btn_resp size_b color2">등록</button>
						</span>
					</li>
				</ul>
<?php }?>

			</div>
		</div> 

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->


<!-- 배송지등록 Layer NEW -->
<div id="inAddress" class="resp_layer_pop hide">
	<h4 class="title">배송지 등록/수정</h4>
	<form id="in_Address" method="post" >
	<input type="hidden" name="insert_mode">
	<input type="hidden" name="address_seq">
	<div class="y_scroll_auto">
		<div class="layer_pop_contents v4">
			<h5 class="stitle">자주쓰는 배송지는 최대 30개까지 등록할 수 있습니다.</h5>
			<div class="resp_table_row input_form">
				<ul class="tr">
					<li class="th">그룹</li>
					<li class="td">
						<select name="select_address_group" class="mb5">
<?php if($TPL_arr_address_group_1){foreach($TPL_VAR["arr_address_group"] as $TPL_V1){?>
<?php if($TPL_V1["address_group"]){?><option value="<?php echo $TPL_V1["address_group"]?>" /><?php echo $TPL_V1["address_group"]?></option><?php }?>
<?php }}?>
							<option value="" />새 그룹 만들기</option>
						</select>
						<input type="text" name="address_group" value="" class="mb5" size="20" maxlength="20" />
						<div><label><input type="checkbox" name="save_delivery_address" value="1" /> 기본 배송지로 지정합니다.</label></div>
					</li>
				</ul>
				<ul class="tr">
					<li class="th">설명</li>
					<li class="td">
						<input type="text" name="address_description" value="" size="65" />
					</li>
				</ul>
				<ul class="tr">
					<li class="th">받는분</li>
					<li class="td">
						<input type="text" name="recipient_user_name" value="" size="20" />
					</li>
				</ul>
				<ul class="tr shipping_tr">
					<li class="th">국가</li>
					<li class="td">
						<input type="hidden" name="international" value="">
						<div class="international_layer">
							<select name="nation_select" style="max-width:100%;">
								<option value="KOREA">대한민국(KOREA)</option>
<?php if($TPL_ship_gl_arr_1){foreach($TPL_VAR["ship_gl_arr"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["nation_str"]?>"><?php echo $TPL_V1["nation_str"]?></option>
<?php }}?>
							</select>
						</div>
					</li>
				</ul>
				<ul class="tr domestic">
					<li class="th">주소</li>
					<li class="td">
						<input type="hidden" name="check_new_zipcode" value="NEW" />
						<input type="text" name="recipient_new_zipcode" value="" class="size_zip_all" readonly />
						<button type="button" class="btn_resp size_b color4" onclick="openDialogZipcode_resp('recipient_');">우편번호 검색</button>
						<!--button type="button" onclick="window.open('../popup/zipcode?mtype=delivery','popup_zipcode','width=600,height=480')" class="btn_move small">주소찾기</button-->
						<input type="hidden" name="recipient_address_type" value="" />
						<div class="address_area">
							<input type="text" name="recipient_address" value="" class="size_address" readonly />
							<input type="text" name="recipient_address_street" value="" class="size_address" readonly style="display:none;" />
						</div>
						<div class="address_area">
							<input type="text" name="recipient_address_detail" value="" class="size_address" placeholder="상세 주소" />
						</div>
					</li>
				</ul>
				<ul class="tr domestic">
					<li class="th">휴대폰</li>
					<li class="td">
						<input type="text" name="recipient_cellphone[]" value="" class="size_phone" /> - <input type="text" name="recipient_cellphone[]" value="" class="size_phone" /> - <input type="text" name="recipient_cellphone[]" value="" class="size_phone" />
					</li>
				</ul>
				<ul class="tr domestic">
					<li class="th">연락처2</li>
					<li class="td">
						<input type="text" name="recipient_phone[]" value="" class="size_phone" /> - <input type="text" name="recipient_phone[]" value="" class="size_phone" /> - <input type="text" name="recipient_phone[]" value="" class="size_phone" />
					</li>
				</ul>
				<ul class="tr international">
					<li class="th">주소</li>
					<li class="td">
						<div class="mt5 mb5"><input type="text" name="international_address" value="" size="55" /> <span class="desc">주소</span></div>
						<input type="text" name="international_town_city" value="" size="30" /> <span class="desc">시도</span>
						<div class="mt5 mb5"><input type="text" name="international_county" value="" size="30" /> <span class="desc">주</span></div>
						<input type="text" name="international_postcode" value="" size="10" /> <span class="desc">우편번호</span>
						<div class="mt5"><input type="text" name="international_country" value="" size="30" /> <span class="desc">국가</span></div>
					</li>
				</ul>
				<ul class="tr international">
					<li class="th">휴대폰</li>
					<li class="td">
						<input type="text" name="international_recipient_cellphone[]" value="" class="size_phone" /> - <input type="text" name="international_recipient_cellphone[]" value="" class="size_phone" /> - <input type="text" name="international_recipient_cellphone[]" value="" class="size_phone" />
					</li>
				</ul>
				<ul class="tr international">
					<li class="th">연락처2</li>
					<li class="td">
						<input type="text" name="international_recipient_phone[]" value="" class="size_phone" /> - <input type="text" name="international_recipient_phone[]" value="" class="size_phone" /> - <input type="text" name="international_recipient_phone[]" value="" class="size_phone" />
					</li>
				</ul>
			</div>
			<div class="btn_area_b">
				<button type="button" id="insert_address" class="btn_resp size_c color2">확인</button>
			</div>
		</div>
	</div>
	</form>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
</div>


<style type="text/css">
<?php if($_GET["popup"]){?>
	#wrapper {position:fixed; width:100% !important; height:100%; overflow:auto;}
	.address_reg {position:relative; padding:10px 15px;}
	.address_reg .pop_close {padding-right:13px; background:url('/data/skin/responsive_diary_petit_gl/images/common/btn_close.gif') no-repeat right;}
	.addAddress {margin-right:10px;}
<?php }?>
</style>
<script type="text/javascript">
	function check_shipping_method(){

		var nation = $("select[name='nation_select'] option:selected").val();
		if(!nation)nation = "KOREA";
		if(nation == "KOREA"){
			$(".domestic").show();
			$(".international").hide();
			$("input[name='international']").val('domestic');
		}else{
			$(".international").show();
			$(".domestic").hide();
			$("input[name='international']").val('1');
		}
	}

	function opener_shipping_method(){
		var nation = opener.$("select[name='nation_select'] option:selected").val();
		//opener.$("div.shipping_method_radio").each(function(){
		//	$(this).hide();
		//});
		if(!nation)nation = "KOREA";
		//opener.$("div.shipping_method_radio").eq(idx).show();
		if(nation == "KOREA"){
			opener.$(".domestic").show();
			opener.$(".international").hide();
			$("input[name='international']").val('domestic');
		}else{
			opener.$(".international").show();
			opener.$(".domestic").hide();
			$("input[name='international']").val('international');
		}
	}

	function delete_address_btn(seq){
		//정말 삭제하시겠습니까?
		var chk = confirm(getAlert('mp016'));
		if(chk == true){
		var str="../mypage_process/delete_address?address_seq=" + seq + "&popup=<?php echo $_GET["popup"]?>";
		$("iframe[name='actionFrame']").attr('src',str);
		}else{
			return;
		}
	}

	function change_address_btn(seq){
		//자주쓰는 배송지로 등록하시겠습니까?
		var chk = confirm(getAlert('mp017'));
		if(chk == true){
		var str="../mypage_process/change_address?address_seq=" + seq + "&popup=<?php echo $_GET["popup"]?>";
		$("iframe[name='actionFrame']").attr('src',str);
		}else{
			return;
		}
	}

	$(function() {
		// 국내/해외 배송 선택
		$("select[name='nation_select']").bind("change",function(){
			check_shipping_method();
		});

		// 해외배송 방법 선택 시
		/*
		$("input[name='shipping_method_international']").bind("click",function(){
			var region = new Array();
<?php if(is_array($TPL_R1=$TPL_VAR["shipping_policy"]["policy"][ 1])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
			region[<?php echo $TPL_K1?>] = new Array();
<?php if(is_array($TPL_R2=$TPL_V1["region"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
			region[<?php echo $TPL_K1?>][<?php echo $TPL_K2?>] = "<?php echo $TPL_V2?>";
<?php }}?>
<?php }}?>
			$("select[name='region'] option").remove();
			var idx = $(this).val();
			for(var i=0;i<region[idx].length;i++){
				$("select[name='region']").append("<option value='"+i+"'>"+region[idx][i]+"</option>");
			}
		});
		*/

		check_shipping_method();

<?php if($TPL_VAR["shipping_policy"]["count"]&&array_sum($TPL_VAR["shipping_policy"]["count"])> 1){?>
		$(".shipping_tr").show();
<?php }else{?>
		$(".shipping_tr").hide();
<?php }?>
<?php if($TPL_VAR["shipping_policy"]["count"][ 0]&&$TPL_VAR["shipping_policy"]["count"][ 1]){?>
		$(".international_layer").show();
<?php }?>

		$(".addAddress").bind("click",function(){

			$("input[name='insert_mode']").val('insert');
			// 배송지 정보 초기화
			$("input[name='address_description']").val('');
			$("input[name='recipient_zipcode[]']").eq(0).val("");
			$("input[name='recipient_zipcode[]']").eq(1).val("");
			$("input[name='recipient_new_zipcode']").val("");
			$("input[name='recipient_address_type']").val("");
			$("input[name='recipient_address']").val("");
			$("input[name='recipient_address_street']").val("");
			$("input[name='recipient_address_detail']").val("");
			$("input[name='recipient_user_name']").val("");
			$("input[name='recipient_phone[]']").each(function(idx){
				$("input[name='recipient_phone[]']").eq(idx).val("");
			});
			$("input[name='recipient_cellphone[]']").each(function(idx){
				$("input[name='recipient_cellphone[]']").eq(idx).val("");
			});
			$("select[name='nation_select'] option[value='KOREA']").attr("selected",true);
			$("input[name='international_address']").val("");
			$("input[name='international_town_city']").val("");
			$("input[name='international_county']").val("");
			$("input[name='international_postcode']").val("");
			$("input[name='international_country']").val("");
			$("input[name='international_recipient_phone[]']").each(function(idx){  $(this).val(""); });
			$("input[name='international_recipient_cellphone[]']").each(function(idx){  $(this).val(""); });

			//배송지 등록 하기
			showCenterLayer('#inAddress');
			//openDialog(getAlert('mp155'), "inAddress", {"width":600,"height":640});
		});

		$(".updateaddress").bind("click",function(){
			var seq = $(this).attr('seq');

			$.ajax({
			  url: '/mypage/delivery_address_ajax',
			  data : {
				  'address_seq':seq
			  },
			  dataType : 'json',
			  success: function(data) {
				if(data.result!==true){
					alert(data.msg);
					return false;
				}

				$("input[name='address_group']").val(data.address_group);
				$("select[name='select_address_group']").val(data.address_group);
				

				if(data.defaults=='Y'){
					$("input[name='save_delivery_address']").attr('checked',true);
				}else{
					$("input[name='save_delivery_address']").removeAttr('checked');
				}

				if(data.international =='domestic'){
					$("input[name='international']").val('domestic');
					$("input[name='address_description']").val(data.address_description);
					$("input[name='recipient_user_name']").val(data.recipient_user_name);
					$("select[name='nation_select'] option[value='KOREA']").prop("selected",true);
					$("input[name='recipient_address_type']").val(data.recipient_address_type);
					$("input[name='recipient_address']").val(data.recipient_address);
					$("input[name='recipient_address_street']").val(data.recipient_address_street);
					$("input[name='recipient_address_detail']").val(data.recipient_address_detail);
					$("input[name='recipient_new_zipcode']").eq(0).val(data.recipient_new_zipcode);

					if ( data.recipient_address_type != 'street' ) {
						$('input[name=recipient_address]').show();
						$('input[name=recipient_address_street]').hide();
					} else {
						$('input[name=recipient_address]').hide();
						$('input[name=recipient_address_street]').show();
					}

					phone = new Array();
					phone = data.recipient_phone.split('-');
					$("input[name='recipient_phone[]']").each(function(idx){
						$("input[name='recipient_phone[]']").eq(idx).val(phone[idx]);
					});

					cellphone = new Array();
					cellphone = data.recipient_cellphone.split('-');
					$("input[name='recipient_cellphone[]']").each(function(idx){
						$("input[name='recipient_cellphone[]']").eq(idx).val(cellphone[idx]);
					});
				}else{
					$("input[name='international']").val('international');
					$("input[name='address_description']").val(data.address_description);
					$("input[name='recipient_user_name']").val(data.recipient_user_name);
					$("select[name='nation_select'] option[value='"+data.nation+"']").prop("selected",true);
					$("input[name='international_county']").val(data.international_county);
					$("input[name='international_address']").val(data.international_address);
					$("input[name='international_town_city']").val(data.international_town_city);
					$("input[name='international_postcode']").val(data.international_postcode);
					$("input[name='international_country']").val(data.international_country);

					phone = new Array();
					phone = data.recipient_phone.split('-');
					$("input[name='international_recipient_phone[]']").each(function(idx){
						$("input[name='international_recipient_phone[]']").eq(idx).val(phone[idx]);
					});

					cellphone = new Array();
					cellphone = data.recipient_cellphone.split('-');
					$("input[name='international_recipient_cellphone[]']").each(function(idx){
						$("input[name='international_recipient_cellphone[]']").eq(idx).val(cellphone[idx]);
					});
				}				

				$("input[name='insert_mode']").val('update');
				$("input[name='address_seq']").val(seq);
				check_shipping_method();
				//배송지 수정하기
				showCenterLayer('#inAddress');
				//openDialog(getAlert('mp156'), "inAddress", {"width":600,"height":640});
			  }
			});
		});

		$("#insert_address").bind("click",function(){
			var f = $("form#in_Address");
			f.attr("action","../mypage_process/delivery_address");
			f.attr("target","actionFrame");
			f[0].submit();
		});

		$("#change_desc").bind("click",function(){
			var order = "<?php echo $_GET["order"]?>";
			if( order == '' || order != "desc_up"){
			parent.document.location.href = "/mypage/delivery_address?tab=<?php echo $_GET["tab"]?>&popup=<?php echo $_GET["popup"]?>&order=desc_up";
			}else if( order != "desc_dn"){
			parent.document.location.href = "/mypage/delivery_address?tab=<?php echo $_GET["tab"]?>&popup=<?php echo $_GET["popup"]?>&order=desc_dn";
			}
		});

		$("#change_name").bind("click",function(){
			var order = "<?php echo $_GET["order"]?>";
			if( order == '' || order != "name_up"){
			parent.document.location.href = "/mypage/delivery_address?tab=<?php echo $_GET["tab"]?>&popup=<?php echo $_GET["popup"]?>&order=name_up";
			}else if( order != "name_dn"){
			parent.document.location.href = "/mypage/delivery_address?tab=<?php echo $_GET["tab"]?>&popup=<?php echo $_GET["popup"]?>&oorder=name_dn";
			}
		});

<?php if($_GET["popup"]){?>
			$(".addressResult").bind("click",function(){
				var seq = $(this).attr('seq');
<?php if($_GET["multiIdx"]==''){?>
				var containerObj = opener.$('body');
<?php }else{?>
				var multiIdx = <?php echo $_GET["multiIdx"]+ 0?>;
				var containerObj = opener.$("form[name='recipient']").eq(multiIdx);
<?php }?>

				$.ajax({
					  url: '/mypage/delivery_address_ajax',
					  data : {
						  'address_seq':seq
					  },
					  dataType : 'json',
					  success: function(data) {
						if(data.result!==true){
							alert(data.msg);
							return false;
						}

						var check_internal = '<?php echo $TPL_VAR["shipping_policy"]["policy"][ 1]?>' ;

						if(!check_internal){
							if(data.international =='domestic'){
								opener.$("select[name='international']",containerObj).val('0');
								opener.$("input[name='address_description']",containerObj).val(data.address_description);
								opener.$("input[name='recipient_user_name']",containerObj).val(data.recipient_user_name);
								opener.$("input[name='recipient_address_type']",containerObj).val(data.recipient_address_type);
								opener.$("input[name='recipient_address']",containerObj).val(data.recipient_address);
								opener.$("input[name='recipient_address_street']",containerObj).val(data.recipient_address_street);
								opener.$("input[name='recipient_address_detail']",containerObj).val(data.recipient_address_detail);
								if(data.recipient_address_type=='street'){
									opener.$("input[name='recipient_address_street']",containerObj).show();
									opener.$("input[name='recipient_address']",containerObj).hide();
								}else{
									opener.$("input[name='recipient_address_street']",containerObj).hide();
									opener.$("input[name='recipient_address']",containerObj).show();
								}
								
								if(opener.$("input[name='recipient_zipcode[]']",containerObj).length == 2){
									zipcode = new Array();
									zipcode = data.recipient_zipcode.split('-');
									opener.$("input[name='recipient_zipcode[]']",containerObj).each(function(idx){
										opener.$("input[name='recipient_zipcode[]']",containerObj).eq(idx).val(zipcode[idx]);
									});
								}else{
									opener.$("input[name='recipient_new_zipcode']",containerObj).val(data.recipient_zipcode);
								}

								phone = new Array();
								phone = data.recipient_phone.split('-');
								opener.$("input[name='recipient_phone[]']",containerObj).each(function(idx)
								{
									opener.$("input[name='recipient_phone[]']",containerObj).eq(idx).val(phone[idx]);
								});

								cellphone = new Array();
								cellphone = data.recipient_cellphone.split('-');
								opener.$("input[name='recipient_cellphone[]']",containerObj).each(function(idx)
								{
									opener.$("input[name='recipient_cellphone[]']",containerObj).eq(idx).val(cellphone[idx]);
								});
								window.close();
							}else{
							//현재 해외배송은 불가능합니다.
							openDialogAlert(getAlert('mp157'),400,150);
							}
						}else{

							if(data.international =='domestic'){
								opener.$("select[name='international']",containerObj).val('0');
								opener.$("input[name='address_description']",containerObj).val(data.address_description);
								opener.$("input[name='recipient_user_name']",containerObj).val(data.recipient_user_name);
								opener.$("input[name='recipient_address']",containerObj).val(data.recipient_address);
								opener.$("input[name='recipient_address_street']",containerObj).val(data.recipient_address_street);
								opener.$("input[name='recipient_address_detail']",containerObj).val(data.recipient_address_detail);
								if(data.recipient_address_type=='street'){
									opener.$("input[name='recipient_address_street']",containerObj).show();
									opener.$("input[name='recipient_address']",containerObj).hide();
								}else{
									opener.$("input[name='recipient_address_street']",containerObj).hide();
									opener.$("input[name='recipient_address']",containerObj).show();
								}
								if(opener.$("input[name='recipient_zipcode[]']",containerObj).length == 2){
									zipcode = new Array();
									zipcode = data.recipient_zipcode.split('-');
									opener.$("input[name='recipient_zipcode[]']",containerObj).each(function(idx){
										opener.$("input[name='recipient_zipcode[]']",containerObj).eq(idx).val(zipcode[idx]);
									});
								}else{
									opener.$("input[name='recipient_new_zipcode']",containerObj).val(data.recipient_zipcode);
								}
							}else{
								opener.$("select[name='international']",containerObj).val('1');
								opener.$("input[name='address_description']",containerObj).val(data.address_description);
								opener.$("input[name='recipient_user_name']",containerObj).val(data.recipient_user_name);
								opener.$("select[name='region']",containerObj).val(data.region);
								opener.$("input[name='international_county']",containerObj).val(data.international_county);
								opener.$("input[name='international_address']",containerObj).val(data.international_address);
								opener.$("input[name='international_town_city']",containerObj).val(data.international_town_city);
								opener.$("input[name='international_postcode']",containerObj).val(data.international_postcode);
								opener.$("input[name='international_country']",containerObj).val(data.international_country);
							}						
							phone = new Array();
							phone = data.recipient_phone.split('-');
							opener.$("input[name='recipient_phone[]']",containerObj).each(function(idx)
							{
								opener.$("input[name='recipient_phone[]']",containerObj).eq(idx).val(phone[idx]);
							});
							opener.$("input[name='international_recipient_phone[]']",containerObj).each(function(idx)
							{
								if(idx<1){
									opener.$("input[name='international_recipient_phone[]']",containerObj).eq(idx).val(phone[idx]);
								}else{
									opener.$("input[name='international_recipient_phone[]']",containerObj).eq(idx).val(phone[1]+phone[2]);
								}
							});

							cellphone = new Array();
							cellphone = data.recipient_cellphone.split('-');
							opener.$("input[name='recipient_cellphone[]']",containerObj).each(function(idx)
							{
								opener.$("input[name='recipient_cellphone[]']",containerObj).eq(idx).val(cellphone[idx]);
							});
							opener.$("input[name='international_recipient_cellphone[]']",containerObj).each(function(idx)
							{
								if(idx<1){
									opener.$("input[name='international_recipient_cellphone[]']",containerObj).eq(idx).val(cellphone[idx]);
								}else{
									opener.$("input[name='international_recipient_cellphone[]']",containerObj).eq(idx).val(cellphone[1]+cellphone[2]);
								}
							});

							opener_shipping_method();
							window.close();
						}
					}
				});
			});
<?php }?>

		// 검은 테두리
<?php if($_GET["popup"]){?>
		$(window).resize(function(){
			var borderWidth = 5;
			$("#wrapper").css({
				//'border' : borderWidth + 'px solid #000',
				'width' : $(window).width()-(borderWidth*2),
				'height' : $(window).height()-(borderWidth*2)
			});
		}).trigger('resize');
<?php }?>

		$("select[name='select_address_group']").bind('change',function(){
			if($(this).val()==""){
				$("input[name='address_group']").val('').show();
			}else{
				$("input[name='address_group']").val($(this).val()).hide();
			}
		}).trigger('change');


	});

	function submitAddressBookFrm(key,value){
		var frmObj = $("form[name='addressBookFrm']");
		if(typeof key != "undefined" && typeof value != "undefined"){
			$("input[name='"+key+"']",frmObj).val(value);
		}
		frmObj.submit();
	}
</script>