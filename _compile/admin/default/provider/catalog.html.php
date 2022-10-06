<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/provider/catalog.html 000014261 */ 
$TPL_group_list_1=empty($TPL_VAR["group_list"])||!is_array($TPL_VAR["group_list"])?0:count($TPL_VAR["group_list"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript">
	$(document).ready(function() {

		var arrSort = {'A.regdate DESC':'최근 입점순',
						'provider_name DESC':'업체명순',
						'provider_id DESC':'입점사ID순',
						'mshop_cnt DESC':'단골미니샵순'};
		gSearchForm.init({'pageid':'provider_catalog','sc':<?php echo $TPL_VAR["scObj"]?>,'displaySort':arrSort});

		$("button[name='providerDetail']").on('click',function(){
			document.location.href = "provider_reg?no="+$(this).attr("no");
		});
		$(".btnSellerAdminLogin").on("click",function(){
			$('#provider_seq').val($(this).attr('data-providerSeq'));
			$('#provider_id').val($(this).attr('data-providerId'));
			document.selladminLoginForm.submit();
		});
		$(".btnSellerGoodsCnt").on("click",function(){
			var providerSeq = $(this).attr("data-providerSeq");
			var providerName = $(this).attr("data-providerName");
			var providerId = $(this).attr("data-providerId");
			$("#goodsPopup .goodsDefault a span").html($(this).attr('data-goodsDefault'));
			$("#goodsPopup .goodsSocial a span").html($(this).attr('data-goodsSocial'));
			$("#goodsPopup .goodsPackage a span").html($(this).attr('data-goodsPackage'));

			$("#goodsPopup .goodsDefault a").attr("href",'./goods/catalog?provider_seq='+providerSeq+'&provider_name='+providerName+'%28'+providerId+'%29');
			$("#goodsPopup .goodsSocial a").attr("href",'./goods/social_catalog?provider_seq='+providerSeq+'&provider_name='+providerName+'%28'+providerId+'%29');
			$("#goodsPopup .goodsPackage a").attr("href",'./goods/package_catalog?provider_seq='+providerSeq+'&provider_name='+providerName+'%28'+providerId+'%29');

			openDialog("입점사 상품", "goodsPopup_"+seq, {"width":400});
		});
	});

	function goods_set($seq){
			var seq = $seq
			openDialog("입점사 상품", "goodsPopup_"+seq, {"width":400});
		};
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>입점사 관리</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><input type="button" value="입점사 등록" onclick="document.location.href='provider_reg'" class="resp_btn active size_L"></span></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브메뉴 바디 : 시작-->
<div id="search_container" class="search_container">
	<form name="providerForm" id="providerForm" class="search_form">
	<input type="hidden" name="sort" value="<?php echo $TPL_VAR["sc"]["display_sort"]?>"/>
	<input type="hidden" name="searchcount" value="<?php echo $TPL_VAR["sc"]["searchcount"]?>"/>
	<input type="hidden" name="perpage"  id="perpage" value="<?php echo $TPL_VAR["sc"]["perpage"]?>" />
	<input type="hidden" name="page" id="page" value="<?php echo $TPL_VAR["sc"]["page"]?>" data-defaultPage=0 >
	
	<table class="table_search">
		<tr data-fid='sc_provider'  <?php if(!in_array('sc_provider',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>입점사</span></th>
			<td>					
				<select name="provider_seq_selector"></select>
				<input type="hidden" class="provider_seq" name="provider_seq" value=''>
			</td>						
		</tr>
		<tr data-fid='sc_provider_status'  <?php if(!in_array('sc_provider_status',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>입점사 상태</span></th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="provider_status" value="all" /> 전체</label>
					<label><input type="radio" name="provider_status" value="Y"/> 정상</label>
					<label><input type="radio" name="provider_status" value="N" /> 종료</label>
				</div>
			</td>
		</tr>

		<tr data-fid='sc_commission_type' <?php if(!in_array('sc_commission_type',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>정산 기준</span></th>
			<td>
				<select name="commission_type">
					<option value="">전체</option>
					<option value="SACO">수수료 방식</option>
					<option value="SUPPLY">공급가 방식</option>
				</select>
			</td>
		</tr>

		<tr data-fid='sc_calcu_count' <?php if(!in_array('sc_calcu_count',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>정산 주기</span></th>
			<td>
				<div class="resp_checkbox">
					<label><input type="checkbox" name="calcu_count[]" class="chkall" value="all" /> 전체</label>
					<label><input type="checkbox" name="calcu_count[]" value="1" /> 월 1회</label>
					<label><input type="checkbox" name="calcu_count[]" value="2" /> 월 2회</label>
					<label><input type="checkbox" name="calcu_count[]" value="4" /> 월 4회</label>
				</div>
			</td>
		</tr>

		<tr data-fid='sc_pgroup_seq'  <?php if(!in_array('sc_pgroup_seq',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>판매 등급</span></th>
			<td>
				<select name="pgroup_seq">
					<option value="">전체</option>
<?php if($TPL_group_list_1){foreach($TPL_VAR["group_list"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["pgroup_seq"]?>"><?php echo $TPL_V1["pgroup_name"]?></option>
<?php }}?>
				</select>
			</td>
		</tr>

		<tr data-fid='sc_regdate'  <?php if(!in_array('sc_regdate',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>입점일</span></th>
			<td>
				<div class="date_range_form">
					<input type="text" name="regdate[]" value="<?php echo $TPL_VAR["sc"]["regdate"][ 0]?>" class="datepicker sdate"  maxlength="10"/>
					-
					<input type="text" name="regdate[]" value="<?php echo $TPL_VAR["sc"]["regdate"][ 1]?>" class="datepicker edate" maxlength="10"/>
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

		<tr data-fid='sc_info_type'  <?php if(!in_array('sc_info_type',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>사업자</span></th>
			<td>
				<div class="resp_checkbox">
					<label><input type="checkbox" name="info_type[]" class="chkall" value="all" /> 전체</label>
					<label><input type="checkbox" name="info_type[]" value="개인" /> 개인</label>
					<label><input type="checkbox" name="info_type[]" value="법인"  /> 법인</label>
				</div>
			</td>
		</tr>

		<tr data-fid='sc_shop_cnt'  <?php if(!in_array('sc_shop_cnt',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>단골 수</span></th>
			<td>
				<input type="text" name="mshop_cnt_s" value="" size="10" maxlength="10" /> 
				~ 
				<input type="text" name="mshop_cnt_e" value="" size="10" maxlength="10" />
			</td>
		</tr>
	</table>
	<div class="search_btn_lay center mt10"></div>
</div>

<div class="contents_dvs v2">
	<div class="list_info_container">
		<div class="dvs_left">	
			<div class="left-btns-txt">검색 <b><?php echo number_format($TPL_VAR["page"]["searchcount"])?></b>개 (총 <b><?php echo number_format($TPL_VAR["page"]["totalcount"])?></b>개)</div>
		</div>
		<div class="dvs_right">	
			<span class="display_sort" sort="<?php echo $TPL_VAR["sc"]["display_sort"]?>"></span>
			<span class="display_quantity" perpage="<?php echo $TPL_VAR["sc"]["perpage"]?>"></span>
		</div>
	</div>
	</form>		
	<table class="table_row_basic">		
		<colgroup>
<?php if(!$TPL_VAR["minishop_service_limit"]){?>
			<col width="5%" />
			<col width="5%" />
			<col width="12%" />
			<col width="7%" />
			<col width="8%" />
			<col width="8%" />
			<col width="8%" />
			<col width="6%" />
			<col width="8%" />
			<col width="8%" />
			<col width="9%" />
			<col width="7%" />
			<col width="11%" />
<?php }else{?>
			<col width="6%" />
			<col width="6%" />
			<col width="11%" />
			<col width="8%" />
			<col width="9%" />
			<col width="9%" />
			<col width="9%" />
			<col width="7%" />
			<col width="9%" />
			<col width="10%" />			
			<col width="7%" />
			<col width="12%" />
<?php }?>
		</colgroup>
		<thead>
		<tr>
			<th>번호</th>
			<th>상태</th>
			<th>입점사명 (코드)</th>
			<th>입점사 ID</th>
			<th colspan="2">
				정산 기준
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/provider', '#tip3')"></span>
			</th>
			<th>정산 주기</th>
			<th>사업자</th>			
			<th>판매 등급</th>
			<th>입점사 상품</th>
<?php if(!$TPL_VAR["minishop_service_limit"]){?>
			<th>미니샵 단골</th>
<?php }?>
			<th>관리</th>
			<th>입점사 로그인</th>
		</tr>
		</thead>
		<tbody>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["_no"]?></td>
			<td><?php echo $TPL_V1["provider_status"]?></td>
			<td class="left"><a href="provider_reg?no=<?php echo $TPL_V1["no"]?>" class="resp_btn_txt v2"><?php echo $TPL_V1["provider_name"]?></a> (<?php echo $TPL_V1["provider_seq"]?>)</td>
			<td class="left"><?php echo $TPL_V1["provider_id"]?></td>
			<td>
<?php if($TPL_V1["commission_type"]=='SACO'||$TPL_V1["commission_type"]==''){?>수수료<?php }else{?>공급가<?php }?> 방식
			</td>
			<td>
<?php if($TPL_V1["commission_type"]=='SUCO'){?>
				정가의 <?php echo $TPL_V1["charge"]?>%
<?php }elseif($TPL_V1["commission_type"]=='SUPR'){?>
				<?php echo number_format($TPL_V1["charge"])?>원
<?php }else{?>
				수수료 <?php echo $TPL_V1["charge"]?>%
<?php }?>
			</td>
			<td>
<?php if($TPL_V1["calcu_count"]!='7'){?>
					월<?php if(!$TPL_V1["calcu_count"]){?>1<?php }else{?><?php echo $TPL_V1["calcu_count"]?><?php }?>회
<?php }else{?>
					주정산
<?php }?>
			</td>
			<td><?php echo $TPL_V1["info_type"]?></td>
			<td><?php echo $TPL_V1["pgroup_name"]?></td>			
			<td>
				<span class="resp_btn_txt v2" onclick="goods_set('<?php echo $TPL_V1["provider_seq"]?>')" >총 <?php echo $TPL_V1["totalGoodsCount"]?>개</span>
				
				<div id="goodsPopup_<?php echo $TPL_V1["provider_seq"]?>" class="hide">
					<table class="table_basic tdc">
						<col width="33%">
						<col width="33%">
						<col width="33%">
						<tr>
							<th>일반</th>
							<th>티켓</th>
							<th>패키지/복합</th>
						</tr>
						<tr>
							<td><a href="/admin/goods/catalog?provider_seq=<?php echo $TPL_V1["provider_seq"]?>&provider_name
							=<?php echo $TPL_V1["provider_name"]?>%28<?php echo $TPL_V1["provider_id"]?>%29" class="blue" target="_blank"><?php echo $TPL_V1["goodsCount"]["goods_default"]?> </a>개</td>
							<td><a href="/admin/goods/social_catalog?provider_seq=<?php echo $TPL_V1["provider_seq"]?>&provider_name
							=<?php echo $TPL_V1["provider_name"]?>%28<?php echo $TPL_V1["provider_id"]?>%29" class="blue" target="_blank"><?php echo $TPL_V1["goodsCount"]["goods_social"]?> </a>개</td>
							<td><a href="/admin/goods/package_catalog?provider_seq=<?php echo $TPL_V1["provider_seq"]?>&provider_name
							=<?php echo $TPL_V1["provider_name"]?>%28<?php echo $TPL_V1["provider_id"]?>%29" class="blue" target="_blank"><?php echo $TPL_V1["goodsCount"]["goods_package"]?> </a>개</td>
						</tr>
					</table>
				</div>
			</td>
<?php if(!$TPL_VAR["minishop_service_limit"]){?>
			<td>
				<a href="../member/catalog?provider_seq=<?php echo $TPL_V1["provider_seq"]?>&provider_name=<?php echo $TPL_V1["provider_name"]?>" target="_blank" class="resp_btn_txt v2"><?php echo number_format($TPL_V1["mshop_cnt"])?>명</a>			
			</td>
<?php }?>
			<td><button class="detail resp_btn v2" name='providerDetail' type="button" no="<?php echo $TPL_V1["no"]?>">수정</button>	</td>
			<td><button type="button" data-providerSeq='<?php echo $TPL_V1["provider_seq"]?>' data-providerId='<?php echo $TPL_V1["provider_id"]?>' class="btnSellerAdminLogin resp_btn"> 로그인</button></td>				
		</tr>
<?php }}?>
<?php }else{?>
			<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
		<tr>
			<td <?php if(!$TPL_VAR["minishop_service_limit"]){?>colspan="14"<?php }else{?>colspan="13"<?php }?>>
<?php if($TPL_VAR["sc"]["provider_name"]){?>
					'<?php echo $TPL_VAR["sc"]["provider_name"]?>' 검색된 입점사가 없습니다.
<?php }else{?>
					등록된 입점사가 없습니다.
<?php }?>
			</td>
		</tr>
			<!-- 리스트데이터 : 끝 -->
<?php }?>
		</tbody>
	</table>
</div>

<!-- 페이징 -->
<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>




<!-- 입점사관리자 로그인 -->
<form name="selladminLoginForm" method="post" action="../../selleradmin/login_process/login" target="_blank">
	<input type="hidden" name="provider_seq" id="provider_seq" value='' />
	<input type="hidden" name="main_id" id="provider_id" />
	<input type="hidden" name="superadmin_login" value="1" />
	<input type="hidden" name="out_login" value="1" />
	<input type="hidden" name="main_pwd" value="-" />
</form>
<!-- 입점사관리자 로그인 -->

<!--<div id="managerPaymentPopup" class="hide"></div>-->

<?php $this->print_("layout_footer",$TPL_SCP,1);?>