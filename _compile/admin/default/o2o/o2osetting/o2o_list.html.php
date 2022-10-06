<?php /* Template_ 2.2.6 2022/05/17 12:36:34 /www/music_brother_firstmall_kr/admin/skin/default/o2o/o2osetting/o2o_list.html 000010315 */ 
$TPL_category_1=empty($TPL_VAR["category"])||!is_array($TPL_VAR["category"])?0:count($TPL_VAR["category"]);
$TPL_address_icon_1=empty($TPL_VAR["address_icon"])||!is_array($TPL_VAR["address_icon"])?0:count($TPL_VAR["address_icon"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/multiple-select.css" />
<script src="/app/javascript/plugin/multiple-select.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/js/o2o/admin-o2o.js?dummy=<?php echo date($TPL_VAR["Ymd"])?>"></script>
<script>
var shipping_address_regist_able_yn = '<?php echo $TPL_VAR["shipping_address_regist_able_yn"]?>';
var shipping_address_max = '<?php echo $TPL_VAR["shipping_address_max"]?>';
</script>
<style>
	a.pg-link { color: rgb(205, 80, 11); }
	table.multi tr td.domain-title-favicon {vertical-align:top;}
	table.curr-simbol tr td.curr_amout {text-align:right;}
	table.curr-simbol tr td.curr_exchange {text-align:left;}
	table.multi tr td.basic-curr-rate {}
	
	.icon-basic {display: inline-block; 
		white-space: nowrap; 
		padding:0 3px; 
		line-height:17px;
		vertical-align: middle; 
		overflow: hidden; 
		text-indent: 0; 
		text-align: center; 
		font-size: 11px; 
		color: #047ae1 !important; 
		border:1px solid #047ae1; 
	}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<input type="hidden" id="chkSMS_chk" value="<?php echo $TPL_VAR["chk"]?>"/>
	<input type="hidden" id="chkSMS_sms_auth" value="<?php echo $TPL_VAR["sms_auth"]?>"/>
	<input type="hidden" id="chkSMS_send_phone" value="<?php echo $TPL_VAR["send_phone"]?>"/>
	<input type="hidden" id="ssl_pay_is_alive" value="<?php echo $TPL_VAR["ssl_pay_is_alive"]?>"/>
	
	<div id="page-title-bar" class="gray-bar">
		
		<!-- // 좌측 버튼 -->
		<ul class="page-buttons-left box">
		</ul>
		<!-- // 좌측 버튼 -->

		<!-- 타이틀 -->
		<div class="page-title">
			<h2><span class="darkgray">매장 리스트</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li>			
				<button type="button" id="btnAddO2O" class="btn_resp b_blue_r">매장 등록</button>				
			</li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<div class="sub-layout-container body-height-resizing">

	<form name="settingForm" method="GET" target="actionFrame">
	<!-- 페이징 관련 변수 -->
	<input type="hidden" name="page" id="page" value="" />
	<input type="hidden" name="perpage" id="perpage" value="" />
	
	<!-- 서브메뉴 바디 : 시작-->
	<div class='slc-body-wrap'>
		<div class="slc-body">
			<!-- 매장 리스트 기능 변경 by hed -->
			<!-- 주소 검색 부분 :: START -->
			<div width="100%">
				<input type="hidden" name="tab_type" id="tab_type" value="input" />
				<table class="fr mb10" cellpadding="0" cellspacing="0" border="0" width="380px" >
				<tr>
					<td style="padding-left: 5px;">
						<select name="arr_src_address_category[]" id="arr_src_address_category" multiple="multiple" class="selMultiClassCategory" style="width:175px;">
<?php if($TPL_category_1){foreach($TPL_VAR["category"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["address_category"]?>" <?php echo $TPL_V1["selected"]?> ><?php echo $TPL_V1["address_category"]?></option>
<?php }}?>
						</select>
					</td>
					<td style="padding-left: 5px;">
						<select name="arr_src_address_icon[]" id="arr_src_address_icon" multiple="multiple" class="selMultiClassIcon" style="width:105px;">
<?php if($TPL_address_icon_1){foreach($TPL_VAR["address_icon"] as $TPL_V1){?>
						<!-- 대표매장은 검색 조건에서 제외 -->
<?php if($TPL_V1["key"]!='default_store'){?>
							<option value="<?php echo $TPL_V1["key"]?>" <?php echo $TPL_V1["selected"]?> ><?php echo $TPL_V1["text"]?></option>
<?php }?>
<?php }}?>
						</select>
					</td>
					<td style="padding-left: 5px;">
						<input type="text" name="src_address_name" id="src_address_name" title="매장명" value="<?php echo $TPL_VAR["sc"]["address_name"]?>" />
					</td>
					<td>
						<button type="button" onclick="src_store_list();" style="width:45px;height:24px; margin-left:5px; background: url('/admin/skin/default/images/common/icon/admin_search_bt.gif') no-repeat center;border:0;cursor:pointer;"></button>
					</td>
				</tr>
				</table>
			</div>
			<!-- 주소 검색 부분 :: END -->

			<div class="<?php if($TPL_VAR["checkO2OService"]){?><?php }else{?>hide<?php }?>">
				<div>
					<table class="table_basic tdc multi">
						<colgroup>
							<col width="10%"/>
							<col width="10%"/>							
							<col width="15%"/>
							<col width="55%"/>
							<col width="10%"/>
						</colgroup>
						<thead>
						<tr>
							<th><input type="checkbox" id="chkAll"/></th>
							<th>번호</th>
							<th>분류</th>
							<th>매장</th>
							<th>관리</th>
						</tr>
						</thead>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
						<tr class="address_tr_<?php echo $TPL_V1["shipping_address_seq"]?> "
							add_type="<?php echo $TPL_V1["add_type"]?>"
							wh_use="<?php if($TPL_V1["wh_use"]){?><?php echo $TPL_V1["wh_use"]?><?php }else{?>N<?php }?>"
							store_scm_seq="<?php if($TPL_V1["wh_use"]){?><?php echo $TPL_V1["store_scm_seq"]?><?php }else{?><?php }?>"
						>
							<td>
								<input type="checkbox" class="chk" name="add_chk[]" value="<?php echo $TPL_V1["shipping_address_seq"]?>" <?php if($TPL_V1["wh_use"]=='N'){?>disabled<?php }?> 
<?php if(is_array($TPL_R2=$TPL_V1["icon"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
									data-<?php echo $TPL_V2["key"]?>="1"
<?php }}?>
								/>
							</td>
							<td>
								<?php echo $TPL_V1["_rno"]?>

							</td>
							<td>
								<?php echo $TPL_V1["address_category"]?>

							</td>
							<td class="left">
								<b><?php echo $TPL_V1["address_name"]?></b>
<?php if(is_array($TPL_R2=$TPL_V1["icon"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<span class="icon-basic icon-<?php echo $TPL_V2["key"]?>"><?php echo $TPL_V2["text"]?></span>
<?php }}?>
								<br/>
<?php if($TPL_V1["address_zipcode"]){?>
<?php if($TPL_V1["address_nation"]=='korea'){?>
									(<?php echo $TPL_V1["address_zipcode"]?>)
<?php if($TPL_V1["address_type"]=='street'){?>
										<?php echo $TPL_V1["address_street"]?>

<?php }else{?>
										<?php echo $TPL_V1["address"]?>

<?php }?>
										<?php echo $TPL_V1["address_detail"]?>

<?php }else{?>
									(<?php echo $TPL_V1["international_postcode"]?>) <?php echo $TPL_V1["international_address"]?> <?php echo $TPL_V1["international_town_city"]?> <?php echo $TPL_V1["international_county"]?> <?php echo $TPL_V1["international_country"]?>

<?php }?>
<?php }?>
							</td>
							<td>
							<button type="button" onclick="insert_address_pop('<?php echo $TPL_V1["shipping_address_seq"]?>');" class="btn_resp b_gray2">수정</button>
									
								
							</td>
						</tr>
<?php }}else{?>
						<tr>
							<td colspan="5">
								매장 정보를 등록하여 주세요.
							</td>
						</tr>
<?php }?>
					</table>

					<button type="button" class="btnO2OConfigDelete btn_resp b_gray mt5">삭제</button>

					<div class="paging_navigation" style="padding-top:20px; margin:auto;"><?php echo $TPL_VAR["page"]["html"]?></div>
				</div>

				<div class="box_style_05 mt20">
					<div class="title">안내</div>
					<ul class="bullet_circle">	
						<li>오프라인 매장의 정보를 등록하여 운영중인 매장을 관리할 수 있습니다.</li>
						<li>매장 정보 노출 설정을 통해 쇼핑몰 스킨에서 매장 정보를 제공할 수 있습니다. (현재 홈페이지 스킨만 반영, 추후 모든 반응형 스킨 반영 예정)</li>
						<li>등록한 매장은 상품 수령 매장, 반송지 설정 시 제공됩니다.</li>
						<li>
							아이콘 안내
							<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/o2o', '#tip1')"></span>
						</>						
					</ul>
				</div>
		
		</div>
	</div>
	</form>
	<!-- 서브메뉴 바디 : 끝 -->


	
	<!-- 삭제 안내 레이어 : start -->
	<div class="hide" id="o2oDeleteInfoLayer">
		<div style="padding-top:5px;">
			<ul class="red mt10">
				<li>매장 삭제 전 아래 유의사항을 반드시 확인하시기 바랍니다.</li>				
			</ul>
			<ul class="mt10">
				<li class="bold">1. 반송지 해당하는 경우 </li>
				<li>설정><a class="link_blue_01" href="../setting/shipping_group">배송비</a>에 반송지 설정을 먼저 변경 후 삭제 가능합니다.</li>				
			</ul>
			<ul class="mt10">
				<li class="bold">2. 매장 수령 사용하는 경우</li>
				<li>설정><a class="link_blue_01" href="../setting/shipping_group">배송비</a>에 수령 매장 목록에서 삭제됩니다. 수령 매장 설정을 먼저 변경 후 삭제를 권장합니다.</li>				
			</ul>
			<ul class="mt10">
				<li class="bold">3. 매장 안내 노출중인 경우</li>
				<li>매장 안내 페이지에 해당 매장에서 삭제됩니다.</li>				
			</ul>
			<ul class="mt10">
				<li class="bold">4. POS 연동중인 경우</li>
				<li>오프라인(POS) 매장 주문, 회원가입 등 연동 기능이 중지됩니다.</li>
			</ul>
			
			<div style="padding-top:10px;text-align:center;">
				<ul class="mt10 mb10">
					<li>선택한 매장을 삭제하시겠습니까?</li>
				</ul>
				<span class="btn large">
					<button type="button" class="btnProcDelO2OSetting" >예</button>
				</span>
				<span class="btn large">
					<button type="button" class="btnCancelDelO2OSetting" >아니오</button>
				</span>
			</div>
		</div>
	</div>
	<!-- 삭제 안내 레이어 : end -->
</div>
<!-- 서브 레이아웃 영역 : 끝 -->

<?php $this->print_("layout_footer",$TPL_SCP,1);?>