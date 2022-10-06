<?php /* Template_ 2.2.6 2022/05/17 12:37:02 /www/music_brother_firstmall_kr/admin/skin/default/setting/shipping_group.html 000012278 */ 
$TPL_grp_list_1=empty($TPL_VAR["grp_list"])||!is_array($TPL_VAR["grp_list"])?0:count($TPL_VAR["grp_list"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/js/admin-shipping.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		
		gSearchForm.init({'pageid':'shipping_group', 'sc':<?php echo $TPL_VAR["scObj"]?>});
		
		$("#chkAll").click(function(){
			if($(this).attr("checked")){
				$(".chk").attr("checked",true).change();
			}else{
				$(".chk").attr("checked",false).change();
			}
		});
	});

	// sort 변경시
	function searchformchange(){
		$("form[name='grpForm']").submit();
	}

	// 그룹삭제 버튼
	function del_group(){
		var grp_seq = new Array();
		$("input[name='shipping_group_seq[]']:checked").each(function(idx){
			grp_seq[idx] = 'grp_seq[]=' + $(this).val();
		});

		if(grp_seq.length > 0){
			openDialogConfirm('선택한 배송그룹이 적용된 상품은 기본 배송그룹으로 자동 적용됩니다.<br/>선택한 배송그룹을 정말 삭제하시겠습니까?',500,170,
			function(){
				var str = grp_seq.join('&');
				$.ajax({
					type: "POST",
					url: "../setting_process/rm_shipping_group",
					dataType : 'json',
					data: str,
					success: function(data){
						openDialogAlert(data.msg,400,140,function(){location.reload();});
					}
				});
			},function(){});
		}else{
			openDialogAlert('삭제할 배송그룹을 선택해주세요.',400,140,'','');
		}
	}

	// 연결상품 보기
	function view_rel_goods(seq){
		window.open('../goods/catalog?ship_grp_seq=' + seq);
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
						openDialogAlert(data.msg,400,140,function(){location.reload();});
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
<?php $this->print_("require_info",$TPL_SCP,1);?>


		<!-- 타이틀 -->
		<div class="page-title">
<?php if(serviceLimit('H_AD')&&$TPL_VAR["view"]["provider_seq"]){?>
			<h2><span class="darkgray"><?php echo $TPL_VAR["view"]["provider_name"]?> →</span> 배송비</h2>
<?php }else{?>
			<h2><span class="darkgray">배송비</h2>
<?php }?>
		</div>

<?php if(serviceLimit('H_AD')){?>
		<div class="page-buttons-left">			
			<button type="button" onclick="document.location.href='/admin/provider/catalog'" class="resp_btn v3 size_L">입점사 리스트</button>			
		</div>
<?php }?>

<?php if(!$TPL_VAR["view"]){?>
		<!-- 우측 버튼 -->
		<div class="page-buttons-right">
			<a <?php if(serviceLimit('H_FR')&&count($TPL_VAR["grp_list"])> 2){?>onclick="<?php echo serviceLimit('A2')?>"<?php }else{?>href="./shipping_group_regist"<?php }?>><button class="resp_btn active2 size_L" type="button">등록</button></a>
		</div>
<?php }?>
	</div>
</div>
<!-- 페이지 타이틀 바 : END -->

<!-- 서브 레이아웃 영역 : START -->
<div id="search_container" class="contents_container">
	<!-- 서브메뉴 바디 : START -->
	
	<form name="grpForm" id="grpForm" class="search_form">
	<input type="hidden" name="provider_seq" value="<?php echo $TPL_VAR["view"]["provider_seq"]?>"/>
	<input type="hidden" name="provider_name" value="<?php echo $TPL_VAR["view"]["provider_name"]?>"/>
	<input type="hidden" name="query_string" value="" />
	<input type="hidden" name="no" />
	<!-- 검색폼 : START -->
<?php $this->print_("shipping_search_form",$TPL_SCP,1);?>

	<!-- 검색폼 : END -->
	
	<div class="list_info_container">
		<div class="dvs_right">	
			<select name="orderby" onchange="searchformchange();" width="80px">
				<option value="desc_regist_date" <?php if($TPL_VAR["sc"]["orderby"]=='desc_regist_date'){?>selected<?php }?>>최근 등록 순</option>
				<option value="desc_update_date" <?php if($TPL_VAR["sc"]["orderby"]=='desc_update_date'){?>selected<?php }?>>최근 수정 순</option>	
				<option value="asc_shipping_group_name" <?php if($TPL_VAR["sc"]["orderby"]=='asc_shipping_group_name'){?>selected<?php }?>>배송그룹명 순</option>
				<option value="desc_total_rel_cnt" <?php if($TPL_VAR["sc"]["orderby"]=='desc_total_rel_cnt'){?>selected<?php }?>>적용상품 많은 순</option>
				<option value="asc_total_rel_cnt" <?php if($TPL_VAR["sc"]["orderby"]=='asc_total_rel_cnt'){?>selected<?php }?>>적용상품 적은 순</option>
			</select>
		</div>
	</div>

	<!-- 리스트 : START -->
	<div class="table_row_frame">
<?php if(!$TPL_VAR["view"]){?>
		<div class="dvs_top">
			<div class="dvs_left"><button type="button" onclick="del_group();" class="resp_btn v3">선택 삭제</button></div>
		</div>
<?php }?>
		<!-- LIST GROUP -->
		<table class="table_row_basic tdc grp-list">
			<colgroup>
				<col width="4%" /><!-- chk box -->
				<col width="4%" /><!-- 번호 -->
				<col width="15%" /><!-- 배송그룹명 -->
				<col width="9%" /><!-- 배송비계산 -->
				<col width="8%" /><!-- 배송가능국가 -->
				<col width="8%" /><!-- 배송방법 -->
				<col width="7%" /><!-- 상품상세안내 -->
				<col width="7%" /><!-- 기본 -->
				<col width="7%" /><!-- 추가 -->
				<col width="7%" /><!-- 희망 -->
				<col width="7%" /><!-- 수령 -->
				<col width="7%" /><!-- 지불방법 -->
				<col width="10%" /><!-- 관리 -->
			</colgroup>
			<thead>
				<tr>
					<th rowspan="2"><label class="resp_checkbox"><input type="checkbox" id="chkAll" /></label></th>
					<th rowspan="2">번호</th>
					<th rowspan="2">배송그룹명<br/>(그룹번호)</th>
					<th rowspan="2">배송비계산</th>
					<th rowspan="2">배송가능국가</th>
					<th rowspan="2">배송방법</th>
					<th rowspan="2">상품상세</th>
					<th colspan="4">배송비</th>
					<th rowspan="2">지불</th>
					<th rowspan="2">관리</th>
				</tr>
				<tr>
					<th width="80px">기본</th>
					<th width="80px">추가</th>
					<th width="80px">희망배송일</th>
					<th width="80px">수령매장</th>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_VAR["grp_list"]){?>
<?php if($TPL_grp_list_1){foreach($TPL_VAR["grp_list"] as $TPL_V1){?>
				<tr>
					<td class="nonpd center" <?php if($TPL_V1["setting_cnt"]){?>rowspan="<?php echo $TPL_V1["setting_cnt"]?>"<?php }?>>
<?php if($TPL_V1["default_yn"]=='Y'){?>
						-
<?php }else{?>
						<label class="resp_checkbox"><input type="checkbox" class="chk" name="shipping_group_seq[]" value="<?php echo $TPL_V1["shipping_group_seq"]?>" /></label>
<?php }?>
					</td>
					<td class="nonpd center" <?php if($TPL_V1["setting_cnt"]){?>rowspan="<?php echo $TPL_V1["setting_cnt"]?>"<?php }?>><?php echo $TPL_V1["_rno"]?></td>
					<td class="nonpd center" <?php if($TPL_V1["setting_cnt"]){?>rowspan="<?php echo $TPL_V1["setting_cnt"]?>"<?php }?>>
						<?php echo $TPL_V1["shipping_group_name"]?> (<?php echo $TPL_V1["shipping_group_seq"]?>)
<?php if($TPL_V1["default_yn"]=='Y'){?>
						<span class="basic_black_box">기본</span>
<?php }?>
					</td>
					<td class="nonpd center" <?php if($TPL_V1["setting_cnt"]){?>rowspan="<?php echo $TPL_V1["setting_cnt"]?>"<?php }?>>
						<?php echo $TPL_V1["calcul_type_txt"]?>계산
<?php if($TPL_V1["shipping_calcul_free_yn"]=='Y'){?>
						<br/>(무료화)
<?php }?>
					</td>
<?php if(is_array($TPL_R2=$TPL_V1["setting"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_K2=>$TPL_V2){$TPL_I2++;?>
					<td class="nonpd center"  rowspan="<?php echo count($TPL_V2)?>">
<?php if($TPL_K2=='korea'){?>대한민국<?php }else{?>해외국가<?php }?>
					</td>
<?php if(is_array($TPL_R3=$TPL_V2)&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
<?php if($TPL_I3> 0){?>
				<tr>
<?php }?>
					<td class="ship-bg" height="45px">
						<?php echo $TPL_V3["shipping_set_name"]?>

<?php if($TPL_V3["set_code_txt"]){?>
						(<?php echo $TPL_V3["set_code_txt"]?>)
<?php }?>
<?php if($TPL_V3["default_yn"]=='Y'){?>
						<span class="basic_black_box">기본</span>
<?php }?>
					</td>
					<td class="its-td-align center ship-bg">
<?php if($TPL_V3["shipping_set_code"]!='direct_store'){?>
						<span class="resp_btn_txt v2" onclick="ship_desc_pop('<?php echo $TPL_V3["shipping_set_seq"]?>');">배송안내</span>
<?php }else{?>
						<span class="gray">배송안내</span>
<?php }?>
					</td>
					<td class="ship-bg"><?php echo $TPL_V3["stdtxt"]?></td>
					<td class="ship-bg"><?php echo $TPL_V3["addtxt"]?></td>
					<td class="ship-bg"><?php echo $TPL_V3["hoptxt"]?></td>
					<td class="ship-bg"><?php echo $TPL_V3["storetxt"]?></td>
					<td class="ship-bg"><?php echo $TPL_V3["prepay_info_txt"]?></td>
<?php if($TPL_I2== 0&&$TPL_I3== 0){?>
					<td class="nonpd center pdt5 pdb5" rowspan="<?php echo (count($TPL_V1["setting"]['korea'])+count($TPL_V1["setting"]['global']))?>">
						<input name="modify_btn" onclick="location.href='../goods/package_catalog?ship_grp_seq=<?php echo $TPL_V1["shipping_group_seq"]?>';" type="button" value="패키지:<?php echo $TPL_V1["package_cnt"]?>개" style="width:92px;" class="resp_btn">
						<div style="height:5px;"></div>
						<input name="modify_btn" onclick="location.href='../goods/catalog?ship_grp_seq=<?php echo $TPL_V1["shipping_group_seq"]?>';" type="button" value="실물상품:<?php echo $TPL_V1["goods_cnt"]?>개" style="width:92px;" class="resp_btn">
						<div style="height:5px;"></div>

<?php if($TPL_VAR["sc"]["provider_seq"]> 1){?>
						<input name="modify_btn" onclick="location.href='./shipping_group_regist?provider_seq=<?php echo $TPL_VAR["sc"]["provider_seq"]?>&provider_name=<?php echo $TPL_VAR["sc"]["provider_name"]?>&shipping_group_seq=<?php echo $TPL_V1["shipping_group_seq"]?>';" type="button" value="수정" class="resp_btn v2">
<?php }else{?>
						<input name="modify_btn" onclick="location.href='./shipping_group_regist?shipping_group_seq=<?php echo $TPL_V1["shipping_group_seq"]?>';" type="button" value="수정" class="resp_btn v2">
<?php }?>
<?php if(!$_GET["provider_seq"]){?>
						
						<input name="shipping_copy_btn" onclick="shipping_copy('<?php echo $TPL_V1["shipping_group_seq"]?>');"type="button" value="복사" class="resp_btn v2">
<?php }?>
					</td>
<?php }?>
				</tr>
<?php }}?>
<?php }}?>
				</tr>
<?php }}?>
<?php }else{?>
				<tr>
					<td class="center" height="45px" colspan="14">
<?php if($TPL_VAR["sc"]["keyword"]){?>
							'<?php echo $TPL_VAR["sc"]["keyword"]?>' 검색된 배송그룹이 없습니다.
<?php }else{?>
							설정된 배송그룹이 없습니다.
<?php }?>
					</td>
				</tr>
<?php }?>
			</tbody>
		</table>
		<!-- 리스트 : END -->
<?php if(!$TPL_VAR["view"]){?>
		<div class="dvs_bottom">
			<div class="dvs_left"><button type="button" onclick="del_group();" class="resp_btn v3">선택 삭제</button></div>
		</div>
<?php }?>
	</div>

	<!-- 페이징 : START -->
	<div class="paging_navigation" style="padding-top:20px; margin:auto;"><?php echo $TPL_VAR["grp_pagin"]["html"]?></div>
	<!-- 페이징 : END -->
	</form>	
	<!-- 서브메뉴 바디 : END -->
</div>
<!-- 서브 레이아웃 영역 : END -->

<!-- 기본검색설정 : 시작 -->
<div class="hide" id="search_detail_dialog"><?php $this->print_("set_search_default",$TPL_SCP,1);?></div>
<!-- 기본검색설정 : 끝 -->

<!-- 배송안내 : 시작 -->
<div id="shipDescPopup" style="display:none;"></div>
<!-- 배송안내 : 끝 -->

<?php $this->print_("layout_footer",$TPL_SCP,1);?>