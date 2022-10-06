<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/mypage/return_view.html 000016020 */ 
$TPL_data_return_item_1=empty($TPL_VAR["data_return_item"])||!is_array($TPL_VAR["data_return_item"])?0:count($TPL_VAR["data_return_item"]);
$TPL_bankReturn_1=empty($TPL_VAR["bankReturn"])||!is_array($TPL_VAR["bankReturn"])?0:count($TPL_VAR["bankReturn"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 반품/교환 상세 @@
- 파일위치 : [스킨폴더]/mypage/return_view.html
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
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvcmV0dXJuX3ZpZXcuaHRtbA==" >반품/교환 상세</span></h2>
		</div>

		<div class="res_table">
			<ul class="thead">
				<li>상품</li>
				<li style="width:100px;">반품수량</li>
				<li style="width:100px;">반품상태</li>
				<li style="width:100px;">반품종류</li>
			</ul>
<?php if($TPL_data_return_item_1){foreach($TPL_VAR["data_return_item"] as $TPL_V1){?>
			<ul class="tbody">
				<li class="item_info">
					<ul class="oc_item_info_detail">
						<li class="img_link">
							<a href='/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>' target='_blank' title="새창"><img src="<?php echo $TPL_V1["image"]?>" class="order_thumb" alt="<?php echo $TPL_V1["goods_name"]?>" /></a>
						</li>
						<li class="detail_spec">
<?php if($TPL_V1["goods_type"]=='gift'){?><img src="/data/skin/responsive_diary_petit_gl/images/common/icon_gift.gif" alt="사은품" vspace=3 /><?php }?>

							<div class="goods_name"><?php echo $TPL_V1["goods_name"]?></div>
							
<?php if($TPL_V1["option1"]){?>
							<div class="oc_res_block">
								<ul class="goods_options">
<?php if($TPL_V1["option1"]){?>
									<li><?php if($TPL_V1["title1"]){?><span class="xtle"><?php echo $TPL_V1["title1"]?></span><?php }?> <?php echo $TPL_V1["option1"]?></li>
<?php }?>
<?php if($TPL_V1["option2"]){?>
									<li><?php if($TPL_V1["title2"]){?><span class="xtle"><?php echo $TPL_V1["title2"]?></span><?php }?> <?php echo $TPL_V1["option2"]?></li>
<?php }?>
<?php if($TPL_V1["option3"]){?>
									<li><?php if($TPL_V1["title3"]){?><span class="xtle"><?php echo $TPL_V1["title3"]?></span><?php }?> <?php echo $TPL_V1["option3"]?></li>
<?php }?>
<?php if($TPL_V1["option4"]){?>
									<li><?php if($TPL_V1["title4"]){?><span class="xtle"><?php echo $TPL_V1["title4"]?></span><?php }?> <?php echo $TPL_V1["option4"]?></li>
<?php }?>
<?php if($TPL_V1["option5"]){?>
									<li><?php if($TPL_V1["title5"]){?><span class="xtle"><?php echo $TPL_V1["title5"]?></span><?php }?> <?php echo $TPL_V1["option5"]?></li>
<?php }?>
								</ul>
							</div>
<?php }?>

<?php if($TPL_V1["goods_type"]=="gift"){?>
<?php if($TPL_V1["gift_title"]){?>
								<div class="mt3">
									<?php echo $TPL_V1["gift_title"]?>

									<button type="button" class="gift_log btn_resp" order_seq="<?php echo $TPL_VAR["data_return"]["order_seq"]?>" item_seq="<?php echo $TPL_V1["item_seq"]?>">자세히</button>
								</div>
<?php }?>
<?php }?>
						</li>
					</ul>
				</li>
				<li><span class="motle">수량:</span> <?php echo $TPL_V1["ea"]?></li>
				<li><span class="motle">상태:</span> <span class="pointcolor"><?php echo $TPL_VAR["data_return"]["mstatus"]?></span></li>
				<li><span class="motle">종류:</span> <?php echo $TPL_VAR["data_return"]["mreturn_type"]?></li>
			</ul>
<?php }}?>
		</div>

		<ul class="order_settle">
			<li class="col1">
				<h4 class="title">
					반품처리&nbsp;
					<button type="button" onclick="document.location.href='/mypage/myqna_write?category=<?php echo urlencode('반품문의')?>'" class="btn_resp size_a color2">문의</button>
				</h4>
				<div class="resp_table_row2">
					<ul>
						<li class="th">반품상태</li>
						<li class="td">:&nbsp; <?php echo $TPL_VAR["data_return"]["mstatus"]?></li>
					</ul>
					<ul>
						<li class="th">반품번호</li>
						<li class="td">:&nbsp; <?php echo $TPL_VAR["data_return"]["return_code"]?></li>
					</ul>
					<ul>
						<li class="th">반품종류</li>
						<li class="td">:&nbsp; <?php echo $TPL_VAR["data_return"]["mreturn_type"]?></li>
					</ul>
					<ul>
						<li class="th">반품접수일</li>
						<li class="td">:&nbsp; <?php echo date('Y년 m월 d일',strtotime($TPL_VAR["data_return"]["regist_date"]))?></li>
					</ul>
					<ul>
						<li class="th">반품완료일</li>
						<li class="td">:&nbsp; <?php if($TPL_VAR["data_return"]["return_date"]){?><?php echo date('Y년 m월 d일',strtotime($TPL_VAR["data_return"]["return_date"]))?><?php }?></li>
					</ul>
				</div>
			</li>
			<li class="col2">
				<form action="../mypage_process/return_modify" target="actionFrame" method="post">
				<input type="hidden" name="return_code" value="<?php echo $TPL_VAR["data_return"]["return_code"]?>" />
				<h4 class="title">
					반품정보&nbsp;
<?php if($TPL_VAR["data_return"]["status"]=='request'){?><button type="submit" class="btn_resp size_a color2">변경</button><?php }?>
				</h4>
				<div class="resp_table_row2 form_style">
					<ul>
						<li class="th">회수방법</li>
						<li class="td">
<?php if($TPL_VAR["data_order"]["payment"]!='pos_pay'){?>
<?php if($TPL_VAR["data_return"]["status"]=='request'){?>
									<label class="label1"><input type="radio" name="return_method" value="user" /> 자가반품</label>
									<label class="label1"><input type="radio" name="return_method" value="shop" /> 택배회수</label>
									<script>$("input[name='return_method'][value='<?php echo $TPL_VAR["data_return"]["return_method"]?>']").attr('checked',true);</script>
<?php }else{?>
									<?php echo $TPL_VAR["data_return"]["mreturn_method"]?>

<?php }?>
<?php }else{?>
<?php if($TPL_VAR["data_return"]["status"]=='request'){?>
									<label class="label1"><input type="radio" name="return_method" value="user" /> 오프라인 매장 반품</label>
									<script>$("input[name='return_method'][value='<?php echo $TPL_VAR["data_return"]["return_method"]?>']").attr('checked',true);</script>
<?php }else{?>
									오프라인 매장 반품
<?php }?>
<?php }?>
						</li>
					</ul>
					<ul>
						<li class="th">휴대폰</li>
						<li class="td">
<?php if($TPL_VAR["data_return"]["status"]=='request'){?>
								<input type="text" name="cellphone[]" class="size_phone" value="<?php echo $TPL_VAR["data_return"]["cellphone"][ 0]?>" />
								<input type="text" name="cellphone[]" class="size_phone" value="<?php echo $TPL_VAR["data_return"]["cellphone"][ 1]?>" />
								<input type="text" name="cellphone[]" class="size_phone" value="<?php echo $TPL_VAR["data_return"]["cellphone"][ 2]?>" />
<?php }else{?>
								<?php echo implode("-",$TPL_VAR["data_return"]["cellphone"])?>

<?php }?>
						</li>
					</ul>
					<ul>
						<li class="th">연락처</li>
						<li class="td">
<?php if($TPL_VAR["data_return"]["status"]=='request'){?>
								<input type="text" name="phone[]" class="size_phone" value="<?php echo $TPL_VAR["data_return"]["phone"][ 0]?>" />
								<input type="text" name="phone[]" class="size_phone" value="<?php echo $TPL_VAR["data_return"]["phone"][ 1]?>" />
								<input type="text" name="phone[]" class="size_phone" value="<?php echo $TPL_VAR["data_return"]["phone"][ 2]?>" />
<?php }else{?>
								<?php echo implode("-",$TPL_VAR["data_return"]["phone"])?>

<?php }?>
						</li>
					</ul>
					<ul>
						<li class="th">회수주소</li>
						<li class="td">
<?php if($TPL_VAR["data_return"]["status"]=='request'){?>
								<input type="text" name="senderZipcode[]" value="<?php echo $TPL_VAR["data_return"]["sender_new_zipcode"]?>" class="size_zip_all" readonly />
								<!--button type="button" id="senderZipcodeButton" class="btn_resp size_b color4" onclick="zipcode_popup(this)">우편번호 검색</button-->
								<button type="button" id="senderZipcodeButton" class="btn_resp size_b color4" onclick="openDialogZipcode_resp('sender');">우편번호 검색</button>

								<input type="hidden" name="senderAddress_type" value="<?php echo $TPL_VAR["data_return"]["sender_address_type"]?>" />
								<div class="address_area2">
									<input type="text" name="senderAddress" value="<?php echo $TPL_VAR["data_return"]["sender_address"]?>" class="size_address <?php if($TPL_VAR["data_return"]["sender_address_type"]=='street'){?>hide<?php }?>" readonly />
									<input type="text" name="senderAddress_street" value="<?php echo $TPL_VAR["data_return"]["sender_address_street"]?>" class="size_address <?php if($TPL_VAR["data_return"]["sender_address_type"]!='street'){?>hide<?php }?>" readonly />
								</div>
								<div class="address_area2">
									<input type="text" name="senderAddressDetail" value="<?php echo $TPL_VAR["data_return"]["sender_address_detail"]?>" class="size_address" placeholder="상세 주소" />
								</div>
<?php }else{?>
								<?php echo implode("-",$TPL_VAR["data_return"]["sender_zipcode"])?><?php if($TPL_VAR["data_return"]["sender_address"]){?><input type="button" name="change_address_btn" class="btn_move small" onclick="address_change_view();" value="<?php if($TPL_VAR["address_type"]=="street"){?>지번 주소보기<?php }else{?>도로명 주소보기<?php }?>"><?php }?>
								<div id="address_zibun" style="display:<?php if($TPL_VAR["address_type"]=="street"){?>none<?php }?>; padding-top:5px;"><?php echo $TPL_VAR["data_return"]["sender_address"]?> <?php echo $TPL_VAR["data_return"]["sender_address_detail"]?></div>
								<div id="address_street" style="display:<?php if($TPL_VAR["address_type"]!="street"){?>none<?php }?>; padding-top:5px;"><?php echo $TPL_VAR["data_return"]["sender_address_street"]?> <?php echo $TPL_VAR["data_return"]["sender_address_detail"]?></div>
<?php }?>
						</li>
					</ul>
					<ul>
						<li class="th">상세사유</li>
						<li class="td">
<?php if($TPL_VAR["data_return"]["status"]=='request'){?>
								<textarea name="return_reason"><?php echo $TPL_VAR["data_return"]["return_reason"]?></textarea>
<?php }else{?>
								<?php echo $TPL_VAR["data_return"]["return_reason"]?>

<?php }?>
						</li>
					</ul>
					<ul>
						<li class="th">배송비 입금</li>
						<li class="td">
<?php if($TPL_VAR["data_return"]["status"]=='request'){?>
								<input type="text" name="shipping_price_depositor" value="<?php echo $TPL_VAR["data_return"]["shipping_price_depositor"]?>" class="size_name" placeholder="입금자명" title="입금자명" />
								<div class="address_area2">
									<select name="shipping_price_bank_account">
										<option value="">입금은행</option>
<?php if($TPL_bankReturn_1){foreach($TPL_VAR["bankReturn"] as $TPL_V1){?>
										<option value="<?php echo $TPL_V1["bank"]?> <?php echo $TPL_V1["accountReturn"]?> <?php echo $TPL_V1["bankUserReturn"]?>"><?php echo $TPL_V1["bank"]?> <?php echo $TPL_V1["accountReturn"]?> <?php echo $TPL_V1["bankUserReturn"]?></option>
<?php }}?>
									</select>
									<script>$("select[name='shipping_price_bank_account'] option[value='<?php echo $TPL_VAR["data_return"]["shipping_price_bank_account"]?>']").attr('selected',true);</script>
								</div>
<?php }else{?>
<?php if($TPL_VAR["data_return"]["shipping_price_bank_account"]){?><?php echo $TPL_VAR["data_return"]["shipping_price_bank_account"]?><?php }?><br />
<?php if($TPL_VAR["data_return"]["shipping_price_depositor"]){?>
								입금자명 : <?php echo $TPL_VAR["data_return"]["shipping_price_depositor"]?>

<?php }?>
<?php }?>
						</li>
					</ul>
				</div>
				</form>
			</li>
		</ul>

		<div class="btn_area_b">
			<a href="/mypage/return_catalog" class="btn_resp size_c">반품 목록</a>
		</div>

		<h3 class="title_sub1">반품 절차</h3>
		<ol class="step_type1">
			<li>
				<p class="tle"><span class="num">1</span> 반품신청</p>
				<p class="cont">고객님의 반품신청이 접수되었습니다.</p>
			</li>
			<li>
				<p class="tle"><span class="num">2</span> 반품처리중</p>
				<p class="cont">고객님의 반품상품을 회수중에 있습니다.</p>
			</li>
			<li>
				<p class="tle"><span class="num">3</span> 반품완료</p>
				<p class="cont">고객님의 반품상품이 회수되었습니다.</p>
			</li>
		</ol>

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->

<div id="gift_use_lay" class="resp_layer_pop hide">
	<h4 class="title">사은품 이벤트 정보</h4>
	<div class="y_scroll_auto">
		<div class="layer_pop_contents v3">
			
		</div>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
</div>

 <script type="text/javascript">
	$(function(){
		// 사은품 지급 조건 상세
		$(".gift_log").bind('click', function(){
			$.ajax({
				type: "post",
				url: "./gift_use_log",
				data: "order_seq="+$(this).attr('order_seq')+"&item_seq="+$(this).attr('item_seq'),
				success: function(result){
					if	(result){
						$("#gift_use_lay .layer_pop_contents").html(result);
						//사은품 이벤트 정보
						showCenterLayer('#gift_use_lay');
						//openDialog(getAlert('mp122'), "gift_use_lay", {"width":"450","height":"220"});
					}
				}
			});
		});

		return_address();

		$("input:radio[name='return_method']").click(function(){
			return_address();
		});
	});

	function return_address(){
		/*
		var type = $("input:radio[name='return_method']:checked").val();
		if(type=='user'){
			var sender_new_Zipcode = "<?php echo $TPL_VAR["config_shipping"]["returnZipcode"][ 0]?><?php echo $TPL_VAR["config_shipping"]["returnZipcode"][ 1]?>";
			var senderAddress = "<?php echo $TPL_VAR["config_shipping"]["returnAddress"]?>";
			var senderAddress_street = "<?php echo $TPL_VAR["config_shipping"]["returnAddress_street"]?>";
			var senderAddressDetail = "<?php echo $TPL_VAR["config_shipping"]["returnAddressDetail"]?>";
		}else{
			var sender_new_Zipcode ="<?php echo $TPL_VAR["data_return"]["sender_new_zipcode"]?>";
			var senderAddress = "<?php echo $TPL_VAR["data_return"]["sender_address"]?>";
			var senderAddress_street = "<?php echo $TPL_VAR["data_return"]["sender_address_street"]?>";
			var senderAddressDetail = "<?php echo $TPL_VAR["data_return"]["sender_address_detail"]?>";
		}
		$("input[name='sender_new_Zipcode']").val(sender_new_Zipcode);
		$("input[name='senderAddress']").val(senderAddress);
		$("input[name='senderAddress_street']").val(senderAddress_street);
		$("input[name='senderAddressDetail']").val(senderAddressDetail);
		*/
	}

	function zipcode_popup(obj){
		window.open('../popup/zipcode?popup=1&zipcode=senderZipcode[]&new_zipcode=sender_new_Zipcode&address=senderAddress&address_street=senderAddress_street&address_detail=senderAddressDetail','popup_zipcode','width=900,height=480');
	}

	function address_change_view(){
		if($("#address_street").css("display") == "none"){
			$("#address_zibun").hide();
			$("#address_street").show();
			$("input[name='change_address_btn']").val("지번 주소보기");
		}else{
			$("#address_zibun").show();
			$("#address_street").hide();
			$("input[name='change_address_btn']").val("도로명 주소보기");
		}
	}
</script>