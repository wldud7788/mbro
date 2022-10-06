<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/setting/shipping_group_regist.html 000029743 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin-shipping.js?dummy=<?php echo date('Ymd')?>"></script>
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

// 기본 배송방법 변경
function chg_base_set(obj){
	$(".controll_td").css('background-color','');
	$(obj).closest(".controll_td").css('background-color','#FFE3BB');
}

// 배송방법 추가 자식창 호출용
function shipping_set_add(nation){
	area_help_tooltip($("."+nation+"_tb"));
}

// 배송방법 수정
function btn_modify_shipping_set(obj){
	var target_cls	= $(obj).closest("tr").attr('class').replace('item_tr ','');
	var nation		= $(obj).closest(".ship_tb").attr('tb_type');
	var target_idx	= target_cls.replace('item_idx_','');
	var shipping_group_seq 	= $("input[name='shipping_group_seq']").val();
	var shipping_group_dummy_seq 	= $("input[name='shipping_group_dummy_seq']").val();
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
	var url = './add_national_pop?nation=' + nation + '&calcul_type=' + calcul_type + '&debug=1';
	var win = window.open('','add_national_pop','toolbar=no, scrollbars=yes, resizable=yes, width=1265, height=900');
	$("#modifyFrm").attr('action',url);
	$("#modifyFrm").attr('target','add_national_pop');
	$("#modifyFrm").submit();
	win.focus();
}

// 배송방법 삭제
function btn_delete_shipping_set(obj){
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
}

// 배송그룹별 계산기준 변경
function calcul_chg(){
	$(".chk_calcul").attr('disabled',true);
	$(".chk_calcul").attr('checked',false);
	$(".chk_free").attr('disabled',true);
	$(".chk_free").attr('checked',false);
	var calcul_type = $("input[name='shipping_calcul_type']:checked").val();
	$("input[name='" + calcul_type + "_calcul_free_yn']").attr('disabled',false);
	var shipping_calcul_txt = '묶음계산-묶음배송';

	if		(calcul_type == 'bundle')	{
		shipping_calcul_txt = '묶음계산-묶음배송';
		$(".bundleCalculDetail").show()
		$(".eachCalculDetail").hide()

	}else if(calcul_type == 'each')		{
		shipping_calcul_txt = '개별계산-개별배송';
		$(".bundleCalculDetail").hide()
		$(".eachCalculDetail").show()

	}else if(calcul_type == 'free')		{
		shipping_calcul_txt = '무료계산-묶음배송';
		$(".bundleCalculDetail").hide()
		$(".eachCalculDetail").hide()
	}
	$(".shipping_calcul_txt").html(shipping_calcul_txt);
}

// 배송그룹별 무료화 변경
function calcul_chg_free(obj){
	var chk_flag	= $(obj).is(":checked");
	var calcul_type	= $(obj).attr('cal_type');
	if(chk_flag){
		$("input[name='" + calcul_type + "_std_free_yn']").attr('disabled',false);
		$("input[name='" + calcul_type + "_add_free_yn']").attr('disabled',false);
		$("input[name='" + calcul_type + "_hop_free_yn']").attr('disabled',false);
	}else{
		$(".chk_calcul").attr('disabled',true);
	}
}

// 배송가능 국가별 팝업
function add_national_pop(nation, shipping_group_seq){
	if($(".cl_shipping_set_code").length >= 6){
		alert('더이상 추가 하실수 없습니다.\n한 배송그룹 내에 배송방법은 최대 6개입니다.');
		return false;
	}
	var calcul_type = $("input[name='shipping_calcul_type']:checked").val();
	var shipping_group_dummy_seq = $("input[name='shipping_group_dummy_seq']").val();
	var url = './add_national_pop?nation=' + nation + '&calcul_type=' + calcul_type + '&shipping_group_seq=' + shipping_group_seq + '&shipping_group_dummy_seq=' + shipping_group_dummy_seq;
	var win = window.open(url,'add_national_pop','toolbar=no, scrollbars=yes, resizable=yes, width=1265, height=900');
	win.focus();
}

// 안내 문구 팝업
function set_lang_pop(){
	openDialog("리스트페이지의 배송안내 문구", "ship_txt_set_lay", {"width":"900","show" : "fade","hide" : "fade"});
}

// ### 배송그룹 최종 저장 ### //
function save_group(){
	var shipping_group_name = $("input[name='shipping_group_name']").val();
	var sendding_address_seq = $("input[name='sendding_address_seq']").val();
	var refund_address_seq = $("input[name='refund_address_seq']").val();
	if($(".item_tr").length > 0){
		$("#groupFrm").submit();
	}else{
		alert('배송방법이 설정되지 않았습니다.\n[+추가] 버튼을 눌러 배송방법을 추가해주세요.');
		return;
	}
}

// 배송그룹 복사
function shipping_copy(seq){
	if(seq){
		openDialogConfirm('이 그룹을 복사해서 새로 등록하시겠습니까?',500,170,
		function(){
			$.ajax({
				type: "POST",
				url: "../setting_process/copyShippingGroup",
				dataType : 'json',
				data: {'group_seq':seq},
				success: function(data){
					openDialogAlert(data.msg,400,140,function(){document.location.href = "../setting/shipping_group";});
				}
			});
		},function(){});
	}else{
		openDialogAlert('복사할 배송그룹을 선택해주세요.',400,140,'','');
	}
}
</script>

<!-- 페이지 타이틀 바 : START -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>배송비 <?php if($TPL_VAR["reg_type"]=='modify'){?>수정<?php }else{?>등록<?php }?></h2>
		</div>	

		<!-- 우측 버튼 -->
		<div class="page-buttons-right">
			<button type="button" class="resp_btn active size_L" onclick="save_group();"><?php if($TPL_VAR["reg_type"]=='modify'){?>수정<?php }else{?>저장<?php }?></button>
		</div>
		
		<!-- 좌측 버튼 -->
		<div class="page-buttons-left">
			<a href="javascript:void(0)" class="resp_btn v3 size_L" onclick="location.href='./shipping_group';">리스트 바로가기</a>
<?php if($_GET["shipping_group_seq"]){?><a href="javascript:void(0)" class="resp_btn v2 size_L" onclick="shipping_copy(<?php echo $_GET["shipping_group_seq"]?>);">복사</a><?php }?>
		</div>
	</div>
</div>
<!-- 페이지 타이틀 바 : END -->

<!-- 서브 레이아웃 영역 : START -->

<!-- 컨텐츠 :: START -->
<form name="groupFrm" id="groupFrm" method="post" action="../setting_process/save_shipping_group" target="actionFrame">
	<input type="hidden" name="shipping_group_seq" value="<?php echo $_GET["shipping_group_seq"]?>" />
	<input type="hidden" name="shipping_group_real_seq" value="<?php echo $_GET["shipping_group_seq"]?>" />
	<input type="hidden" name="shipping_group_dummy_seq" value="<?php echo $TPL_VAR["shipping_group_dummy_seq"]?>" />
	
	<!-- 기본정보 :: START -->
	<div class="contents_dvs">
	<div class="item-title">기본정보</div>				
	
	<input type="hidden" name="shipping_provider_seq" value="<?php echo $TPL_VAR["provider_seq"]?>"/>
	<input type="hidden" name="shipping_group_type" value="Y"/>

	<table class="table_basic thl">	
	
	<tr>
		<th>배송그룹명</th>
		<td>
			<input type="text" name="shipping_group_name" class="line" value="<?php echo $TPL_VAR["ship_grp"]["shipping_group_name"]?>" /> 
<?php if($TPL_VAR["ship_grp"]["default_yn"]=='Y'){?>			
			<input type="hidden" name="base_grp" value="Y" />
			(<span class="red">기본 배송그룹</span>으로 삭제할 수 없습니다)
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
				<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/shipping_group', '#tip1', 'sizeR')"></span>
			
				<label><input type="radio" name="shipping_calcul_type" value="each" /> 개별계산-개별배송</label>
				<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/shipping_group', '#tip2', 'sizeR')"></span>
			
				<label><input type="radio" name="shipping_calcul_type" value="free" /> 무료계산-묶음배송</label>
				<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/shipping_group', '#tip3', 'sizeR')"></span>	
			</div>
		</td>
	</tr>

	<tr class="bundleCalculDetail">
		<th>배송비 추가 설정</th>
		<td>						
			<label class="resp_checkbox">
				<input type="checkbox" name="bundle_calcul_free_yn" class="chk_free resp_checkbox" cal_type="bundle" value="Y" /> 무료계산-묶음배송 배송그룹이 적용된 상품과 함께 주문하면, 배송그룹으로 계산된 배송비
			</label>
			<div class="resp_checkbox">
				( 
				<label><input type="checkbox" name="bundle_std_free_yn" class="chk_calcul" value="Y" /> 기본</label>
				<label><input type="checkbox" name="bundle_add_free_yn" class="chk_calcul" value="Y" /> 추가</label>			 
				<label><input type="checkbox" name="bundle_hop_free_yn" class="chk_calcul" value="Y" /> 희망배송일</label>
				) 무료	
			 </div>
		</td>
	</tr>

	<tr class="eachCalculDetail">
		<th>배송비 추가 설정</th>
		<td>				
			<label class="resp_checkbox">
				<input type="checkbox" name="each_calcul_free_yn" class="chk_free" cal_type="each" value="Y" /> 무료계산-묶음배송 배송그룹이 적용된 상품과 함께 주문하면, 배송그룹으로 계산된 배송비
			</label>
			<div class="resp_checkbox">
				( 
				<labe><input type="checkbox" name="each_std_free_yn" class="chk_calcul" value="Y" /> 기본</labe>
				<label><input type="checkbox" name="each_add_free_yn" class="chk_calcul" value="Y" /> 추가</label>
				<label><input type="checkbox" name="each_hop_free_yn" class="chk_calcul" value="Y" /> 희망배송일</label> 
				) 무료	
			</div>										
		</td>
	</tr>
	
	<tr>
		<th>
			반송지	
			<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/shipping_group', '#tip4', '530')"></span><br/>
			<button type="button" class="resp_btn v2"  onclick="shipping_address_pop('refund');">설정</button>
			
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
<?php }else{?>						
<?php if(!$TPL_VAR["ship_grp"]["refund_address"]["shipping_address_seq"]){?>반송지를 설정하세요. <?php }?>입점사가 배송한 상품을 구매자가 MY페이지에서 반품 시 설정된 반송지가 안내되어집니다.				
<?php }?>
			</span>
		
		</td>
	</tr>			
	</table>
	</div>
	<!-- 기본정보 :: END -->
	
	<!-- 연결된 상품 :: START -->
	<div class="contents_dvs">		
		<div class="item-title">
			연결된 상품
			<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/shipping_group', '#tip5')"></span>
		</div>		

		<input type="hidden" name="total_rel_cnt" value="<?php echo $TPL_VAR["ship_grp"]["total_rel_cnt"]?>" />
		
		<table class="table_basic v8 tdc">
			<col width="10%"><col width="10%"><col width="10%"><col ><col ><col width="10%">
			<thead>
			<tr>
				<th rowspan="2">상품</th>
				<th rowspan="2">연결</th>
				<th colspan="4">
					상품별 배송비 안내
					<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/shipping_group', '#tip9', 'sizeR')"></span>
				</th>
			</tr>
		
			<tr>
				<th>언어</th>
				<th>
					배송비 안내
					<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/shipping_group', '#tip6')"></span>
				</th>
				<th>
					해외배송 가능여부 안내
					<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/shipping_group', '#tip7')"></span>
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
					<span class="resp_btn" onclick="set_lang_pop();">보기</span>
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
		
		<div class="resp_message">
			- 상품리스트화면에서의 배송비 안내 문구 설정은 본사만 가능합니다.
		</div>
	</div>	
	<!-- 연결상품된 상품 :: END -->

	<!-- 배송가능국가:대한민국 :: START -->
	<div class="contents_dvs">
		<div class="title_dvs">
			<div class="item-title">배송가능국가 : 대한민국</div>
			<button type="button" onclick="add_national_pop('korea', '<?php echo $_GET["shipping_group_seq"]?>');" class="resp_btn v2">추가</button>		
		</div>
		<div class="korea_area">
			<table class="table_basic v7 ship_tb korea_tb" tb_type="korea" >
			
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
					국내배송이 가능하시면 국내배송방법을 추가하세요.
				</td>
			</tr>
			</tbody>
			</table>
		</div>
	</div>
	<!-- 배송가능국가:대한민국 :: END -->

	<!-- 배송가능국가:해외국가 :: START -->
	<div class="contents_dvs">
		<div class="title_dvs">
			<div class="item-title">배송가능국가 : 해외국가</div>
			<button type="button" onclick="add_national_pop('global', '<?php echo $_GET["shipping_group_seq"]?>');" class="resp_btn v2">추가</button>		
		</div>
		<div class="global_area">
			<table class="table_basic v7 ship_tb global_tb" tb_type="global">
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
	<div class="contents_dvs mt20">
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
					<textarea name="admin_memo"  style="width:98%" rows="5"><?php echo $TPL_VAR["ship_grp"]["admin_memo"]?></textarea>
				</td>
				<td>
					<div style="overflow:auto;height:60px;width:98%;border:1px solid #cccccc;padding: 10px 5px;background:#f7f7f7;text-align:left;"><?php echo $TPL_VAR["ship_grp"]["system_memo"]?></div>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
<!-- 메모 및 처리내역 :: END -->
</form>
<!-- 컨텐츠 :: END -->

<!-- 서브 레이아웃 영역 : END -->

<!-- 수정용 폼 Obj :: START -->
<form name="modifyFrm" id="modifyFrm" method="post" action="../setting/add_national_pop" target="actionFrame">
<input type="hidden" name="mode" value="modify" />
<input type="hidden" name="nation" value="" />
<input type="hidden" name="idx" value="" />
<input type="hidden" name="shipping_group_seq" value="<?php echo $_GET["shipping_group_seq"]?>" />
<input type="hidden" name="shipping_group_real_seq" value="<?php echo $_GET["shipping_group_seq"]?>" />
<input type="hidden" name="shipping_group_seq" value="" />
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

<!-- 반송지 사용안내 :: START -->
<div class="hide" id="refund_address_pop_area">
	등록된 반송지 주소는 ↓아래와 같이 사용됩니다.<br/><br/>
	<table class="info-table-style" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<th class="its-th center" rowspan="2">주소</th>
		<th class="its-th center" rowspan="2">
			MY페이지<br/>
			반품/교환 신청 시<br/>
			자가 반품 반송 주소
		</th>
		<th class="its-th center" colspan="3">택배 자동화 연동 출고처리 시 보내는 주소</th>
	</tr>
	<tr>
		<th class="its-th center">굿스플로</th>
		<th class="its-th center">롯데택배</th>
		<th class="its-th center">우체국택배</th>
	</tr>
	<tr>
		<td class="center">반송지</td>
		<td class="center red">○</td>
		<td class="center red">○</td>
		<td class="center red">○</td>
		<td class="center">X</td>
	</tr>
	</table>
</div>
<!-- 반송지 사용안내 :: END -->

<!-- 배송비계산기준안내 :: START -->
<div class="hide" id="ship_calcul_type_area">
	<div class="pdb5">● [묶음계산-묶음배송] 본 배송그룹이 적용된 해당 상품(추가구성상품 포함)들의 배송비를 묶어서 계산함</div>
	<table class="info-table-style" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<th class="its-th center" width="70px">주문상품</th>
		<th class="its-th center" width="315px">배송비 계산</th>
		<th class="its-th center">설명</th>
	</tr>
	<tr>
		<td class="left">상품①</td>
		<td class="left" rowspan="3">
			배송비 = 기본배송비 부과조건(상품①+상품②+상품③)<br/>
			&nbsp;&nbsp;&nbsp;&nbsp; + 추가배송비 부과조건(상품①+상품②+상품③)
		</td>
		<td class="left" rowspan="3">
			판매자 입장에서 해당 상품이 함께 주문되면<br/>
			1개의 운송장번호로 함께 합포장 배송이 가능한 상품으로<br/>
			소비자에게 부과하는 배송비를 통합 계산합니다.<br/>
			<span class="desc">※ 상품 출고 시 필요한 경우 (수량/상품별)부분출고와 (다른주문과의)합포장출고 기능을 지원합니다.</span>
		</td>
	</tr>
	<tr>
		<td class="left">상품②</td>
	</tr>
	<tr>
		<td class="left">상품③</td>
	</tr>
	</table>

	<div class="pdb5 pdt20">● [개별계산-개별배송] 본 배송그룹이 적용된 해당 상품(추가구성상품 포함)들의 배송비를 상품별로 각각 계산함</div>
	<table class="info-table-style" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<th class="its-th center" width="70px">주문상품</th>
		<th class="its-th center" width="315px">배송비 계산</th>
		<th class="its-th center">설명</th>
	</tr>
	<tr>
		<td class="left">상품④</td>
		<td class="left">
			배송비 = 기본배송비 부과조건(상품④)<br/>
            &nbsp;&nbsp;&nbsp;&nbsp; + 추가배송비 부과조건(상품④)
		</td>
		<td class="left" rowspan="3">
			판매자 입장에서 해당 상품이 함께 주문되면<br/>
			여러 개의 운송장번호로 각각 개별 배송되어야 하는 상품으로<br/>
			소비자에게 부과하는 배송비를 개별 계산합니다.<br/>
			<span class="desc">※ 상품 출고 시 필요한 경우 (수량/상품별)부분출고와 (다른주문과의)합포장출고 기능을 지원합니다.</span>
		</td>
	</tr>
	<tr>
		<td class="left">상품⑤</td>
		<td class="left">
			배송비 = 기본배송비 부과조건(상품⑤)<br/>
            &nbsp;&nbsp;&nbsp;&nbsp; + 추가배송비 부과조건(상품⑤)
		</td>
	</tr>
	<tr>
		<td class="left">상품⑥</td>
		<td class="left">
			배송비 = 기본배송비 부과조건(상품⑥)<br/>
            &nbsp;&nbsp;&nbsp;&nbsp; + 추가배송비 부과조건(상품⑥)
		</td>
	</tr>
	</table>

	<div class="pdb5 pdt20">● [무료계산-묶음배송] 본 배송그룹이 적용된 해당 상품(추가구성상품 포함)들의 기본 배송비는 무료. 단, 추가배송비(도서산간, 희망배송일)는 세팅에 따라 부과 가능</div>
	<table class="info-table-style" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<th class="its-th center" width="70px">주문상품</th>
		<th class="its-th center" width="315px">배송비 계산</th>
		<th class="its-th center">설명</th>
	</tr>
	<tr>
		<td class="left">상품⑦</td>
		<td class="left" rowspan="3">
			배송비 = 기본배송비 무료(상품⑦+상품⑧+상품⑨)<br/>
            &nbsp;&nbsp;&nbsp;&nbsp; + 추가배송비 부과조건(상품⑦+상품⑧+상품⑨)
		</td>
		<td class="left" rowspan="3">
			판매자 입장에서 해당 상품이 주문되면<br/>
			조건 없이 무료 배송합니다.<br/>
			<span class="desc">※ 상품 출고 시 필요한 경우 (수량/상품별)부분출고와 (다른주문과의)합포장출고 기능을 지원합니다.</span>
			<br/>
			<span class="desc">※ 본 배송그룹은 [묶음계산-묶음배송]과 [개별계산-개별배송]의 배송비를 무료화할 수도 있습니다.</span>
		</td>
	</tr>
	<tr>
		<td class="left">상품⑧</td>
	</tr>
	<tr>
		<td class="left">상품⑨</td>
	</tr>
	</table>

	<div class="center pdt20">
		<span class="btn large cyanblue"><button onclick="closeDialog('ship_calcul_type_area');" type="button">닫기</button></span>
	</div>
</div>
<!-- 배송비계산기준안내 :: END -->

<!-- 상품리스트화면에서 상품별 배송비안내 :: START -->
<div class="hide" id="ship_goodsprice_pop_area">
	<img src="/admin/skin/default/images/common/img_shipping.png" />
</div>
<!-- 상품리스트화면에서 상품별 배송비안내 :: END -->

<!-- 리스트화면 배송안내 문구설정 :: START -->
<div id="ship_txt_set_lay" class="hide">
	<table class="table_basic v7 v10">
	<colgroup>
		<col width="30%" />
		<col width="35%" />
		<col width="35%" />
	</colgroup>
	<tr>
		<th colspan="2">구분</th>
		<th>안내 문구</th>
	</tr>
	<tr>
		<th rowspan="4">배송비(기본배송방법의 기본배송비 기준) 안내</th>
		<th class="left">무료배송일때</th>
		<td><?php echo $TPL_VAR["info_msg"]["dv001"]["cus_msg"]?></td>
	</tr>
	<tr>
		<th class="left">고정 배송비 일 때</th>
		<td><?php echo $TPL_VAR["info_msg"]["dv002"]["cus_msg"]?></td>
	</tr>
	<tr>
		<th class="left">조건부 무료배송 일 때</th>
		<td><?php echo $TPL_VAR["info_msg"]["dv003"]["cus_msg"]?></td>
	</tr>
	<tr>
		<th class="left">조건부 차등배송비 일 때</th>
		<td><?php echo $TPL_VAR["info_msg"]["dv004"]["cus_msg"]?></td>
	</tr>
	<tr>
		<th class="left">해외배송 안내</th>
		<th class="left">해외국가 배송이 가능 할 때</th>
		<td><?php echo $TPL_VAR["info_msg"]["dv005"]["cus_msg"]?></td>
	</tr>
	</table>

	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>
<!-- 리스트화면 배송안내 문구설정 :: END -->


<?php $this->print_("layout_footer",$TPL_SCP,1);?>