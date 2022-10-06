<?php /* Template_ 2.2.6 2022/05/17 12:37:02 /www/music_brother_firstmall_kr/admin/skin/default/setting/shipping_group_regist.html 000025226 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/js/admin-shipping.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript">
	var default_yn = '<?php echo $TPL_VAR["ship_grp"]["default_yn"]?>';
	$(document).ready(function() {

		$(".custom-select-box-multi").on('click',function(){
			var layer = $(".custom-select-box-layer").css('left');
			//alert(layer);
		});

		// 배송그룹별 계산기준 선택시
		$("input[name='shipping_calcul_type']").on('change',function(){
			calcul_chg();
		});

		$(".chk_free").on('change',function(){
			calcul_chg_free($(this));
		});

		calcul_chg();

		// 수정시 자동 체크값 정의
<?php if($TPL_VAR["reg_type"]=='modify'){?>
		// 배송비 기준 정의
		$("input[name='shipping_calcul_type'][value=<?php echo $TPL_VAR["ship_grp"]["shipping_calcul_type"]?>]").attr("checked", "checked").trigger('change');
		// 무료계산정의
<?php if($TPL_VAR["ship_grp"]["shipping_calcul_type"]!='free'&&$TPL_VAR["ship_grp"]["shipping_calcul_free_yn"]=='Y'){?>
		$("input[name='<?php echo $TPL_VAR["ship_grp"]["shipping_calcul_type"]?>_calcul_free_yn']").attr("checked",true).trigger('change');
<?php if($TPL_VAR["ship_grp"]["shipping_std_free_yn"]=='Y'){?>
		$("input[name='<?php echo $TPL_VAR["ship_grp"]["shipping_calcul_type"]?>_std_free_yn']").attr("checked",true);
<?php }?>
<?php if($TPL_VAR["ship_grp"]["shipping_add_free_yn"]=='Y'){?>
			$("input[name='<?php echo $TPL_VAR["ship_grp"]["shipping_calcul_type"]?>_add_free_yn']").attr("checked",true);
<?php }?>
<?php if($TPL_VAR["ship_grp"]["shipping_hop_free_yn"]=='Y'){?>
				$("input[name='<?php echo $TPL_VAR["ship_grp"]["shipping_calcul_type"]?>_hop_free_yn']").attr("checked",true);
<?php }?>
<?php }?>

						// 기존 item 불러오기
						$("#actionFrame").attr('src','../setting_process/add_shipping_item?mode=modify&grp_seq=<?php echo $TPL_VAR["ship_grp"]["shipping_group_seq"]?>');
<?php }?>

							// 안내)네이버페이 이용시
							$("button#npay_shipping_setting_guide").on("click",function(){
								openDialog("알림", "npay_shipping_setting_guide_lay", {"width":"1080","height":"750","show" : "fade","hide" : "fade"});
							});
						});

						// 배송방법 수정
						function btn_modify_shipping_set(obj){
<?php if($TPL_VAR["sc"]["provider_seq"]){?>
							alert('입점사정보는 수정할 수 없습니다.');
<?php }else{?>
							var target_cls			= $(obj).closest("tr").attr('class').replace('item_tr ','');
							var nation				= $(obj).closest(".ship_tb").attr('tb_type');
							var target_idx			= target_cls.replace('item_idx_','');

							var shipping_group_seq 	= $("#groupFrm input[name='shipping_group_seq']").val();

							//임시 데이터 처리를 위해 무조건 데이터는 dummy로 처리 후 이후에 임시 데이터 이전하는 형식으로 변경
							var shipping_group_dummy_seq = $('#groupFrm input[name="shipping_group_dummy_seq"]').val();
							var shipping_group_name = $("input[name='shipping_group_name']").val();

							// input 박스들의 값을 수정창에 던짐.
							$("#modifyFrm").find("input[name='nation']").val(nation);
							$("#modifyFrm").find("input[name='idx']").val(target_idx);
							$("#modifyFrm").find("input[name='shipping_group_seq']").val(shipping_group_seq);
							$("#modifyFrm").find("input[name='shipping_group_name']").val(shipping_group_name);
							$("#modifyFrm").find("input[name='shipping_group_dummy_seq']").val(shipping_group_dummy_seq);

							$("#modifyFrm > #data_lay").html(''); // 초기화 필수
							$("."+nation+"_tb").find("."+target_cls+"_input").each(function(idx,input){
								$("#modifyFrm > #data_lay").append(input.outerHTML);
							});

							var calcul_type = $("input[name='shipping_calcul_type']:checked").val();
							var url = './add_national_pop?nation=' + nation + '&calcul_type=' + calcul_type;
							var win = window.open('','add_national_pop','toolbar=no, scrollbars=yes, resizable=yes, width=1265, height=900');
							$("#modifyFrm").attr('action',url);
							$("#modifyFrm").attr('target','add_national_pop');
							$("#modifyFrm").submit();
							win.focus();
<?php }?>
							}

							// 배송방법 삭제
							function btn_delete_shipping_set(obj){
<?php if($TPL_VAR["sc"]["provider_seq"]){?>
								alert('입점사정보는 삭제할 수 없습니다.');
<?php }else{?>
								if(confirm('해당 배송방법을 삭제하시겠습니까?')){
									var target_cls	= $(obj).closest("tr").attr('class').replace('item_tr ','');
									var nationTb	= $(obj).closest(".ship_tb").attr('tb_type');
									var	set_seq		= $(obj).closest("tr").find(".set_seq_input").val();
									$("."+nationTb+"_tb").find("."+target_cls).remove();
									$("#groupFrm").append('<input type="hidden" name="delete_set_seq[]" value="' + set_seq + '" />');
									if($("."+nationTb+"_tb").find(".tbody").find("tr").length == 0){
										var nationMsg	= '국내배송';
										if(nationTb == 'global') nationMsg	= '해외배송';
										var baseTr		= '<tr base_tr="Y"><td class="center" colspan="3">'+nationMsg+'이 가능하시면 '+nationMsg+'방법을 추가하세요.</td></tr>';
										$("."+nationTb+"_tb").find(".tbody").append(baseTr);
									}
								}
<?php }?>
								}
</script>

<!-- 페이지 타이틀 바 : START -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>배송비 <?php if($TPL_VAR["reg_type"]=='modify'){?>수정<?php }else{?>등록<?php }?></h2>
		</div>

		<!-- 좌측 버튼 -->
		<div class="page-buttons-left">
			<button type="button" onclick="document.location.href='./shipping_group<?php if($TPL_VAR["sc"]["provider_seq"]){?>?provider_seq=<?php echo $TPL_VAR["sc"]["provider_seq"]?>&provider_name=<?php echo $TPL_VAR["sc"]["provider_name"]?><?php }?>'" class="resp_btn v3 size_L">리스트 바로가기</button>
<?php if(!$TPL_VAR["sc"]["provider_seq"]){?><button type="button" onclick="shipping_copy(<?php echo $_GET["shipping_group_seq"]?>);" class="resp_btn v2 size_L">복사</button><?php }?>
		</div>

<?php if(!$TPL_VAR["sc"]["provider_seq"]){?>
		<!-- 우측 버튼 -->
		<div class="page-buttons-right">
			<button type="button" class="resp_btn active2 size_L" onclick="save_group();"><?php if($TPL_VAR["reg_type"]=='modify'){?>수정<?php }else{?>저장<?php }?></button>
		</div>
<?php }?>
	</div>
</div>
<!-- 페이지 타이틀 바 : END -->

<form name="groupFrm" id="groupFrm" method="post" action="../setting_process/save_shipping_group" target="actionFrame">
	<input type="hidden" name="shipping_group_seq" value="<?php echo $_GET["shipping_group_seq"]?>" />
	<input type="hidden" name="shipping_group_real_seq" value="<?php echo $_GET["shipping_group_seq"]?>" />
	<input type="hidden" name="shipping_group_dummy_seq" value="<?php echo $TPL_VAR["shipping_group_dummy_seq"]?>" />
	<input type="hidden" name="shipping_provider_seq" value="<?php echo $TPL_VAR["provider_seq"]?>"/>
	<input type="hidden" name="shipping_group_type" value="Y"/>

	<!-- 서브 레이아웃 영역 : START -->
	<div class="contents_container">
		<!-- 서브메뉴 바디 : START -->
		<!-- 컨텐츠 :: START -->
		<!-- 기본정보 :: START -->
		<div class="contents_dvs">
			<div class="item-title">기본정보</div>
			<table class="table_basic thl">
				<tr>
					<th>배송그룹명</th>
					<td>
						<input type="text" name="shipping_group_name" class="line" value="<?php echo $TPL_VAR["ship_grp"]["shipping_group_name"]?>" />
<?php if($TPL_VAR["ship_grp"]["default_yn"]=='Y'){?>
						<input type="hidden" name="base_grp" value="Y" />
						(<span class="red">기본 배송그룹</span>으로 삭제할 수 없습니다<?php if(serviceLimit('H_AD')&&!$_GET["provider_seq"]){?>. 또한 입점사가 ‘본사위탁배송’을 요청 시 최초 연결되는 배송그룹입니다<?php }?>)
<?php }?>
					</td>
				</tr>

				<tr>
					<th>배송그룹 번호</th>
					<td><?php if($TPL_VAR["reg_type"]=='modify'){?><?php echo $_GET["shipping_group_seq"]?><?php }else{?>자동생성<?php }?></td>
				</tr>

				<tr>
					<th>배송비 계산 기준</th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="shipping_calcul_type" value="bundle" checked /> 묶음계산-묶음배송</label>
							<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/shipping_group', '#tip1', 'sizeR')"></span>

							<label><input type="radio" name="shipping_calcul_type" value="each" /> 개별계산-개별배송</label>
							<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/shipping_group', '#tip2', 'sizeR')"></span>

							<label><input type="radio" name="shipping_calcul_type" value="free" /> 무료계산-묶음배송</label>
							<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/shipping_group', '#tip3', 'sizeR')"></span>
						</div>
					</td>
				</tr>

				<tr class="bundleCalculDetail">
					<th>배송비 추가 설정</th>
					<td>
						<label class="resp_checkbox">
							<input type="checkbox" name="bundle_calcul_free_yn" class="chk_free" cal_type="bundle" value="Y" /> 무료계산-묶음배송 배송그룹이 적용된 상품과 함께 주문하면, 배송그룹으로 계산된 배송비
						</label>
						( <div class="resp_checkbox">
						<label class="mr5"><input type="checkbox" name="bundle_std_free_yn" class="chk_calcul" value="Y" /> 기본</label>
						<label class="mr5"><input type="checkbox" name="bundle_add_free_yn" class="chk_calcul" value="Y" /> 추가</label>
						<label><input type="checkbox" name="bundle_hop_free_yn" class="chk_calcul" value="Y" /> 희망배송일</label>
					</div> ) 무료
					</td>
				</tr>

				<tr class="eachCalculDetail">
					<th>배송비 추가 설정</th>
					<td>
						<label class="resp_checkbox">
							<input type="checkbox" name="each_calcul_free_yn" class="chk_free" cal_type="each" value="Y" /> 무료계산-묶음배송 배송그룹이 적용된 상품과 함께 주문하면, 배송그룹으로 계산된 배송비
						</label>
						( <div class="resp_checkbox">
						<label><input type="checkbox" name="each_std_free_yn" class="chk_calcul" value="Y" /> 기본</label>
						<label><input type="checkbox" name="each_add_free_yn" class="chk_calcul" value="Y" /> 추가</label>
						<label><input type="checkbox" name="each_hop_free_yn" class="chk_calcul" value="Y" /> 희망배송일</label>
					</div> ) 무료
					</td>
				</tr>

				<tr>
					<th>
						반송지
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/shipping_group', '#tip4')"></span><br/>
<?php if(!$TPL_VAR["sc"]["provider_seq"]&&$TPL_VAR["ship_grp"]["default_yn"]=='Y'){?>
						<button type="button" class="resp_btn v2" onclick="shipping_address_pop('refund');">설정</button>
<?php }?>
					</th>
					<td>
						<input type="hidden" name="refund_address_seq" value="<?php echo $TPL_VAR["ship_grp"]["refund_address"]["shipping_address_seq"]?>" />
						<input type="hidden" name="refund_scm_type" value="<?php if($TPL_VAR["ship_grp"]["refund_address"]["add_type"]=='scm'){?>Y<?php }else{?>N<?php }?>" />
						<span class="refund_txt">
<?php if($TPL_VAR["ship_grp"]["refund_address"]["shipping_address_seq"]){?>
						[<?php echo $TPL_VAR["ship_grp"]["refund_address"]["address_category"]?> > <?php echo $TPL_VAR["ship_grp"]["refund_address"]["address_name"]?>]
<?php if($TPL_VAR["ship_grp"]["refund_address"]["address_nation"]=="global"){?>
<?php if($TPL_VAR["ship_grp"]["refund_address"]["international_postcode"]){?>(<?php echo $TPL_VAR["ship_grp"]["refund_address"]["international_postcode"]?>)<?php }?>
						<?php echo $TPL_VAR["ship_grp"]["refund_address"]["international_address"]?>

						<?php echo $TPL_VAR["ship_grp"]["refund_address"]["international_town_city"]?>

						<?php echo $TPL_VAR["ship_grp"]["refund_address"]["international_county"]?>

						<?php echo $TPL_VAR["ship_grp"]["refund_address"]["international_country"]?>

<?php }else{?>
<?php if($TPL_VAR["ship_grp"]["refund_address"]["address_zipcode"]){?>
						(<?php echo $TPL_VAR["ship_grp"]["refund_address"]["address_zipcode"]?>)
<?php }?>
<?php if($TPL_VAR["ship_grp"]["refund_address"]["address_type"]=='street'){?>
						<?php echo $TPL_VAR["ship_grp"]["refund_address"]["address_street"]?>

<?php }else{?>
						<?php echo $TPL_VAR["ship_grp"]["refund_address"]["address"]?>

<?php }?>
						<?php echo $TPL_VAR["ship_grp"]["refund_address"]["address_detail"]?>

<?php }?>
<?php }?>
						
					</span>
<?php if($TPL_VAR["ship_grp"]["default_yn"]!='Y'){?>
						<div class="resp_message v2">
							- 반송지는 기본 배송지에서만 변경할 수 있습니다.
							<a href="shipping_group_regist?shipping_group_seq=1" target="_blank" class="resp_btn_txt">기본 배송지</a>
						</div>
<?php }?>
						<div class="desc">
<?php if($TPL_VAR["sc"]["provider_seq"]){?>
<?php if(!$TPL_VAR["ship_grp"]["refund_address"]["shipping_address_seq"]){?>(입점사 미설정 상태) <?php }?>입점사가 배송한 상품을 구매자가 MY페이지에서 반품 시 설정된 반송지가 안내되어집니다
<?php }else{?>
<?php if(!$TPL_VAR["ship_grp"]["refund_address"]["shipping_address_seq"]){?>반송지를 설정하세요. <?php }?>
<?php }?>
						</div>
					</td>
				</tr>
			</table>
		</div>

		<div class="contents_dvs">
			<div class="item-title">
				연결된 상품
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/shipping_group', '#tip5')"></span>
			</div>

			<input type="hidden" name="total_rel_cnt" value="<?php echo $TPL_VAR["ship_grp"]["total_rel_cnt"]?>" />

			<table class="table_basic tdc">
				<col width="10%"><col width="10%"><col width="10%"><col ><col ><col width="10%">
				<thead>
				<tr>
					<th rowspan="2">상품</th>
					<th rowspan="2">연결</th>
					<th colspan="4">
						상품별 배송비 안내
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/shipping_group', '#tip9', 'sizeR')"></span>
					</th>
				</tr>

				<tr>
					<th>언어</th>
					<th>
						배송비 안내
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/shipping_group', '#tip6')"></span>
					</th>
					<th>
						해외배송 가능여부 안내
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/shipping_group', '#tip7')"></span>
					</th>
					<th>노출문구</th>
				</tr>
				</thead>
				<tr>
					<th>실물</th>
					<td>
<?php if($TPL_VAR["ship_grp"]["target_goods_cnt"]> 0){?>
						<a href="../goods/catalog?ship_grp_seq=<?php echo $TPL_VAR["ship_grp"]["shipping_group_seq"]?>" target="_blank"><span class="resp_btn_txt v2"><?php echo number_format($TPL_VAR["ship_grp"]["target_goods_cnt"])?> 개</span></a>
<?php }else{?>
						0 개
<?php }?>
					</td>
					<td rowspan="2">
						<?php echo $TPL_VAR["language"]["value"]["name"]?>

					</td>
<?php if($TPL_VAR["grp_summary"]){?>
					<td rowspan="2">
						<?php echo $TPL_VAR["grp_summary"]["default_type_txt"]?>

					</td>
					<td rowspan="2">
<?php if($TPL_VAR["grp_summary"]["gl_shipping_yn"]=='Y'){?>
						<?php echo $TPL_VAR["info_msg"]["dv005"]["cus_msg"]?>

<?php }else{?>
						해외국가 배송불가로 표시되지 않습니다.
<?php }?>
					</td>
<?php }else{?>
					<td rowspan="2" colspan="2">
						<span class="gray">먼저 배송그룹을 생성하세요.</span>
					</td>
<?php }?>
					<td rowspan="2">
<?php if($TPL_VAR["sc"]["provider_seq"]){?>
						<span class="resp_btn" onclick="set_lang_pop('view');">보기</span>
<?php }else{?>
						<button type="button" class="resp_btn" onclick="set_lang_pop('set');">통합설정</button>
<?php }?>
					</td>
				</tr>
				<tr>
					<th>패키지</th>
					<td>
<?php if($TPL_VAR["ship_grp"]["target_package_cnt"]> 0){?>
						<a href="../goods/package_catalog?ship_grp_seq=<?php echo $TPL_VAR["ship_grp"]["shipping_group_seq"]?>" target="_blank"><span class="resp_btn_txt v2"><?php echo number_format($TPL_VAR["ship_grp"]["target_package_cnt"])?> 개</span></a>
<?php }else{?>
						0 개
<?php }?>
					</td>
				</tr>
			</table>
		</div>

		<!-- 배송가능국가:대한민국 :: START -->
		<div class="contents_dvs">
			<div class="title_dvs">
				<div class="item-title">배송가능국가 : 대한민국</div>
				<button type="button" onclick="add_national_pop('korea', '<?php echo $_GET["shipping_group_seq"]?>');" class="resp_btn v2">추가</button>
			</div>

			<div class="korea_area">
				<table class="table_basic ship_tb korea_tb" tb_type="korea" >
					<colgroup>
						<col width="10%" />
						<col />
						<col width="10%" />
					</colgroup>
					<thead>
					<tr>
						<th>배송방법</th>
						<th>
							<span class="shipping_calcul_txt">묶음계산-묶음배송</span>
						</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody class="tbody">
					<tr base_tr="Y">
						<td class="center" colspan="3">
							국내배송이 가능하시면 국내배송방법을 추가하세요.
						</td>
					</tr>
					</tbody>
				</table>
			</div>

			<div class="resp_message">
				- 네이버페이 배송 규정 안내 <a href="https://www.firstmall.kr/customer/faq/1098" target="_blank" class="resp_btn_txt">자세히 보기</a>
			</div>
		</div>
		<!-- 배송가능국가:대한민국 :: END -->

		<!-- 배송가능국가:해외국가 :: START -->
		<div class="contents_dvs">
			<div class="title_dvs">
				<div class="item-title">배송가능국가 : 해외국가</div>
				<button type="button" class="resp_btn v2" onclick="add_national_pop('global', <?php echo $_GET["shipping_group_seq"]?>);">추가</button>
			</div>

			<div class="global_area">
				<table class="table_basic ship_tb global_tb" tb_type="global">
					<colgroup>
						<col width="10%" />
						<col />
						<col width="10%" />
					</colgroup>
					<thead>
					<tr>
						<th>배송방법</th>
						<th><span class="shipping_calcul_txt">묶음계산-묶음배송</span></th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody class="tbody">
					<tr base_tr="Y">
						<td class="center" colspan="3">
							해외배송이 가능하시면 해외배송방법을 추가하세요.
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		<!-- 배송가능국가:해외국가 :: END -->


		<!-- 메모 및 처리내역 :: START -->
		<div class="contents_dvs">
			<table class="table_basic">
				<colgroup>
					<col width="50%" />
					<col width="50%" />
				</colgroup>
				<thead>
				<tr>
					<th>관리 메모</th>
					<th>처리 내역</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>
						<textarea name="admin_memo"  style="width:99%; height:60px;padding:5px 5px;border:0px;"><?php echo $TPL_VAR["ship_grp"]["admin_memo"]?></textarea>
					</td>
					<td>
						<div style="overflow:auto;height:60px;width:99%;border:0px solid #cccccc;padding: 5px 5px;background:#f7f7f7;text-align:left;line-height:16px;"><?php echo $TPL_VAR["ship_grp"]["system_memo"]?></div>
					</td>
				</tr>
				</tbody>
			</table>
		</div>
		<!-- 메모 및 처리내역 :: END -->
		<!-- 컨텐츠 :: END -->
</form>
<!-- 서브메뉴 바디 : END -->
</div>
<!-- 서브 레이아웃 영역 : END -->

<!-- 수정용 폼 Obj :: START -->
<form name="modifyFrm" id="modifyFrm" method="post" action="../setting/add_national_pop" target="actionFrame">
	<input type="hidden" name="mode" value="modify" />
	<input type="hidden" name="nation" value="" />
	<input type="hidden" name="idx" value="" />
	<input type="hidden" name="shipping_group_seq" value="<?php echo $_GET["shipping_group_seq"]?>" />
	<input type="hidden" name="shipping_group_real_seq" value="<?php echo $_GET["shipping_group_seq"]?>" />
	<input type="hidden" name="shipping_group_dummy_seq" value="<?php echo $TPL_VAR["shipping_group_dummy_seq"]?>" />
	<input type="hidden" name="shipping_group_name" value="" />
	<div id="data_lay" class="">
	</div>
</form>
<!-- 수정용 폼 Obj :: END -->

<!-- 장소리스트 팝업 :: START -->
<div class="hide" id="shipping_address_pop_area">
</div>
<!-- 장소리스트 팝업 :: END -->

<!-- 배송안내 :: START -->
<div class="hide" id="shipDescPopup">
</div>
<!-- 배송안내 :: END -->

<!-- 배송상세지역 :: START -->
<div class="hide" id="ship_zone_pop_area">
</div>
<!-- 배송상세지역 :: END -->

<!-- 상품리스트화면에서 상품별 배송비안내 :: START -->
<div class="hide" id="ship_goodsprice_pop_area">
	<img src="/admin/skin/default/images/common/img_shipping.png" />
</div>
<!-- 상품리스트화면에서 상품별 배송비안내 :: END -->

<!-- 네이버페이 이용시 안내 :: START -->
<div id="npay_shipping_setting_guide_lay" class="hide">
<?php $this->print_("naverpay_desc",$TPL_SCP,1);?>

</div>
<!-- 네이버페이 이용시 안내 :: END -->

<!-- 리스트화면 배송안내 문구설정 :: START -->
<div id="ship_txt_set_lay" class="hide">
	<form name="msg_frm" method="post" action="../setting_process/msg_modify" target="actionFrame">
		<input type="hidden" name="language_set" value="<?php echo $TPL_VAR["language"]["codecd"]?>" />
		<table class="table_basic v4">
			<colgroup>
				<col width="140px" />
				<col width="180px" />
				<col width="250px" />
				<col width="250px" />
			</colgroup>
			<tr>
				<th colspan="2" >구분</th>
				<th>설정</th>
				<th>원본</th>
			</tr>
			<tr>
				<th rowspan="4">배송비(기본배송방법의 기본배송비 기준) 안내</th>
				<th >무료배송일때</th>
				<td><input type="text" class="msg_cl" name="msgarr[1]" value="<?php echo $TPL_VAR["info_msg"]["dv001"]["cus_msg"]?>" /></td>
				<td><?php echo $TPL_VAR["info_msg"]["dv001"]["msg"]?></td>
			</tr>
			<tr>
				<th>고정 배송비 일 때</th>
				<td><input type="text" class="msg_cl" name="msgarr[2]" value="<?php echo $TPL_VAR["info_msg"]["dv002"]["cus_msg"]?>" /></td>
				<td><?php echo $TPL_VAR["info_msg"]["dv002"]["msg"]?></td>
			</tr>
			<tr>
				<th>조건부 무료배송 일 때</th>
				<td><input type="text" class="msg_cl" name="msgarr[3]" value="<?php echo $TPL_VAR["info_msg"]["dv003"]["cus_msg"]?>" /></td>
				<td><?php echo $TPL_VAR["info_msg"]["dv003"]["msg"]?></td>
			</tr>
			<tr>
				<th>조건부 차등배송비 일 때</th>
				<td><input type="text" class="msg_cl" name="msgarr[4]" value="<?php echo $TPL_VAR["info_msg"]["dv004"]["cus_msg"]?>" /></td>
				<td><?php echo $TPL_VAR["info_msg"]["dv004"]["msg"]?></td>
			</tr>
			<tr>
				<th>해외배송 안내</th>
				<th>해외국가 배송이 가능 할 때</th>
				<td><input type="text" class="msg_cl" name="msgarr[5]" value="<?php echo $TPL_VAR["info_msg"]["dv005"]["cus_msg"]?>" /></td>
				<td><?php echo $TPL_VAR["info_msg"]["dv005"]["msg"]?></td>
			</tr>
		</table>
	</form>

	<div class="footer">
		<button type="button" onclick="save_ship_msg();" class="resp_btn active size_XL">적용</button>
		<button type="button" onclick="closeDialogEvent(this);" class="resp_btn v3 size_XL">취소</button>
	</div>
</div>
<!-- 리스트화면 배송안내 문구설정 :: END -->
<!-- 리스트화면 배송안내 문구보기 :: START -->
<div id="ship_txt_view_lay" class="hide">
	<table class="table_basic">
		<colgroup>
			<col width="260px" />
			<col width="180px" />
			<col width="" />
		</colgroup>
		<tr>
			<th colspan="2">구분</th>
			<th>안내 문구</th>
		</tr>
		<tr>
			<th rowspan="4">배송비(기본배송방법의 기본배송비 기준) 안내</th>
			<th>무료배송일때</th>
			<td><?php echo $TPL_VAR["info_msg"]["dv001"]["cus_msg"]?></td>
		</tr>
		<tr>
			<th>고정 배송비 일 때</th>
			<td><?php echo $TPL_VAR["info_msg"]["dv002"]["cus_msg"]?></td>
		</tr>
		<tr>
			<th>조건부 무료배송 일 때</th>
			<td><?php echo $TPL_VAR["info_msg"]["dv003"]["cus_msg"]?></td>
		</tr>
		<tr>
			<th>조건부 차등배송비 일 때</th>
			<td><?php echo $TPL_VAR["info_msg"]["dv004"]["cus_msg"]?></td>
		</tr>
		<tr>
			<th>해외배송 안내</th>
			<th>해외국가 배송이 가능 할 때</th>
			<td><?php echo $TPL_VAR["info_msg"]["dv005"]["cus_msg"]?></td>
		</tr>
	</table>

	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
	</div>

</div>
<!-- 리스트화면 배송안내 문구보기 :: END -->


<?php $this->print_("layout_footer",$TPL_SCP,1);?>