<?php /* Template_ 2.2.6 2022/05/17 12:36:59 /www/music_brother_firstmall_kr/admin/skin/default/setting/member_sale.html 000022553 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL_data_1=empty($TPL_VAR["data"])||!is_array($TPL_VAR["data"])?0:count($TPL_VAR["data"]);?>
<!-- 회원설정 : 등급 -->
<script type="text/javascript">
	function sale_write(){
<?php if($TPL_VAR["config_system"]["service"]["max_member_sale_cnt"]-$TPL_VAR["use_member_sale_cnt"]<= 0){?>

			openDialog("안내", "AddLimitPopup", {"width":"350","height":"180"});

<?php }else{?>

<?php if($TPL_VAR["config_system"]["service"]["max_member_sale_cnt"]>$TPL_VAR["use_member_sale_cnt"]){?>

			$.get('member_sale_write', function(data) {
				$('#gradePopup').html(data);
				var _w = $(window).width() - 100;
				openDialog("혜택 세트 만들기", "gradePopup", {"width":_w,"height":"750"});
			});

<?php }else{?>

			$.get('member_payment?type=full&totalCnt=<?php echo $TPL_VAR["config_system"]["service"]["max_member_sale_cnt"]?>', function(data) {
				$('#PaymentPopup').html(data);
				openDialog("등급별 구매혜택 세트 추가 신청", "PaymentPopup", {"width":"800","height":"650"});
			});
<?php }?>

<?php }?>

	}

	function member_account_log(){
		$.get('member_account_log', function(data) {
			$('#PaymentPopup').html(data);
			openDialog("결제내역", "PaymentPopup", {"width":"800","height":"650"});
		});
	}


	function goods_select_method(){
		openDialog("상품별 구매혜택", "goodsSelectMethod", {"width":"800","height":"400"});
	}

	function member_sale_payment(){

		$.get('member_payment', function(data) {
			$('#PaymentPopup').html(data);
			openDialog("등급별 구매혜택 세트 추가 신청", "PaymentPopup", {"width":"800","height":"650"});
		});

	}

	function sale_modify(sale_seq){
		$.get('member_sale_write?sale_seq='+sale_seq, function(data) {
			$('#gradePopup').html(data);
			var _w = $(window).width() - 100;
			openDialog("혜택 세트 수정하기", "gradePopup", {"width":_w,"height":"750"});
		});
	}

	function sale_del(sale_seq, sale_title){
		$.get('../setting/member_sale_delete?sale_seq='+sale_seq, function(data) {

			$('#gradePopup').html(data);
			openDialog("세트 삭제", "gradePopup", {"width":"600","height":"250"});
		});
	}
	$(document).ready(function() {
		$("button[name='grade_help']").bind("click",function(){
			openDialog("회원등급별 구매혜택 세트 안내", "grade_help", {"width":1000,"height":450});
		});
		apply_input_style();

	});

	$('#board_charge').live('click', function (){
	});
</script>

<div class="box_style_02 pd15 mt20">	
	<div class="fx14">
		현재, <b>최대 <?php echo $TPL_VAR["config_system"]["service"]["max_member_sale_cnt"]?>개</b>의 구매혜택을 설정 가능합니다.
	</div>	
	
	<ul class="bullet_circle mt20 mb20">
		<li>기본 세트 : <b><?php echo $TPL_VAR["default_member_sale_cnt"]?></b>개 (<?php echo $TPL_VAR["config_system"]["service"]["name"]?>무료제공)</li>
		<li>추가 세트 : <b><?php echo $TPL_VAR["config_system"]["service"]["max_member_sale_cnt"]-$TPL_VAR["default_member_sale_cnt"]?></b>개</li>
		<li>이용 세트 : <b><?php echo $TPL_VAR["use_member_sale_cnt"]?></b>개 (잔여 <b><?php echo $TPL_VAR["config_system"]["service"]["max_member_sale_cnt"]-$TPL_VAR["use_member_sale_cnt"]?></b>개)</li>			
	</ul>
	
<?php if(serviceLimit('H_FR')){?>
		<div class="gray">
		- 구매 혜택 세트를 2개 이상으로 운영하시려면 프리미엄몰Plus+(기본 세트 3개) 또는 독립몰Plus+(기본 세트 5개)로 업그레이드 하세요. 
		<a href="#" class="resp_btn v2" onclick="serviceUpgrade();">업그레이드</a>
	</div>
<?php }?>	

	<div>
		<span class="gray">
			- 구매 혜택 세트는 최초 1회 결제 후 계속 사용이 가능 합니다. 
			<span class="hide"><?php if(serviceLimit('H_FR')){?>또는 <?php }?>구매 혜택 세트(세트 1개당 22,000원 : 최초 1회 결제 후 계속 사용 가능)를 추가해 주세요.</span>
		</span>		
		<input class="resp_btn active ml10" type="button" value="혜택 세트 추가"  <?php if($TPL_VAR["functionLimit"]){?>  onclick="servicedemoalert('use_f');" <?php }else{?> onclick="member_sale_payment();" <?php }?> >
		<input class="resp_btn v2 b_gray2" type="button" value="결제내역"  <?php if($TPL_VAR["functionLimit"]){?>  onclick="servicedemoalert('use_f');" <?php }else{?> onclick="member_account_log();" <?php }?>>
	</div>				
</div>

<div class="contents_dvs">
	<div class="item-title">
		회원등급별 구매혜택
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip15', 'sizeM')"></span>
		<span class="desc">상품별로 회원 구매 혜택을 다르게 설정할 수 있습니다.</span>
	</div>

	<input type="hidden" name="grade_mode"/>
	<table class="table_basic tdc lh18">
		<col width="40" /><col width="100" /><col width="80" /><col width="100" /><?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?><col width="" /><?php }}?>	
		<thead>
			<tr>
				<th rowspan="2" colspan="4">세트 종류</th>
				<th colspan="<?php echo $TPL_VAR["gcount"]?>">등급</th>
			</tr>	
		<tr>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<th><?php echo $TPL_V1["group_name"]?></th>
<?php }}?>
		</tr>
		</thead>
<?php if($TPL_VAR["data"]){?>
<?php if($TPL_data_1){$TPL_I1=-1;foreach($TPL_VAR["data"] as $TPL_V1){$TPL_I1++;?>	
		<tr <?php if($TPL_V1["_no"]!= 1){?>style="border-top:1px solid #0f4897"<?php }?>>
			<th rowspan="8"><?php echo $TPL_V1["totalcount"]-$TPL_V1["_no"]+ 1?></th>
			<th rowspan="8">
				[<?php echo $TPL_V1["sale_seq"]?>]<?php echo $TPL_V1["sale_title"]?><br><button onclick="sale_modify('<?php echo $TPL_V1["sale_seq"]?>');" class="resp_btn v2">수정</button><br><?php if($TPL_I1> 0||$_GET["page"]> 1){?><input type="button" id="sale_del_btn" onclick="sale_del('<?php echo $TPL_V1["sale_seq"]?>', '<?php echo $TPL_V1["sale_title"]?>');" class="resp_btn v3 mt5" value="삭제"><?php }?>
			</th>
			<th rowspan="4">추가할인</th>
			<th>조건</th>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<td><?php if($TPL_V1[$TPL_V2["group_seq"]]["sale_use"]){?><?php echo $TPL_V1[$TPL_V2["group_seq"]]["sale_use"]?><?php }else{?>조건없음<?php }?></td>
<?php }}?>
		</tr>
		<tr>
			<th>할인</th>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<td><?php if($TPL_V1[$TPL_V2["group_seq"]]["sale_price"]){?><?php echo $TPL_V1[$TPL_V2["group_seq"]]["sale_price"]?> <?php echo $TPL_V1[$TPL_V2["group_seq"]]["sale_price_type"]?><?php }else{?>0% 할인<?php }?></td>
<?php }}?>
		</tr>
		<tr>
			<th>추가옵션</th>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<td><?php if($TPL_V1[$TPL_V2["group_seq"]]["sale_option_price"]){?><?php echo $TPL_V1[$TPL_V2["group_seq"]]["sale_option_price"]?> <?php echo $TPL_V1[$TPL_V2["group_seq"]]["sale_option_price_type"]?><?php }else{?>0% 할인<?php }?></td>
<?php }}?>
		</tr>
		<tr>
			<th>예외</th>
			<td colspan="<?php echo $TPL_V1["gcount"]?>" class="clear">	
			
<?php if($TPL_V1["issuegoods"]||$TPL_V1["issuecategorys"]){?>
			<table class="table_basic thl v3">									
				<tbody>
<?php if($TPL_V1["issuegoods_sale"]){?>
					<tr>
						<th>상품</th>								
						<td>
							<div class="wx600 ">
								<div class="goods_list_header">
									<table class="table_basic fix tdc">
										<colgroup>										
<?php if(serviceLimit('H_AD')){?>
											<col width="25%" />
											<col width="55%" />
<?php }else{?>
											<col width="80%" />
<?php }?>
											<col width="20%" />
										</colgroup>
										<tbody>
											<tr>										
<?php if(serviceLimit('H_AD')){?>
											<th>입점사명</th>
<?php }?>
											<th>상품명</th>
											<th>판매가</th>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="goods_list">
									<table class="table_basic fix tdc">
										<colgroup>										
<?php if(serviceLimit('H_AD')){?>
											<col width="25%" />
											<col width="55%" />
<?php }else{?>
											<col width="80%" />
<?php }?>
											<col width="20%" />
										</colgroup>
										<tbody>										
<?php if(is_array($TPL_R2=$TPL_V1["issuegoods"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["type"]=='sale'){?>
											<tr rownum="<?php echo $TPL_V2["goods_seq"]?>">											
<?php if(serviceLimit('H_AD')){?>
													<td><?php echo $TPL_V2["provider_name"]?></td>
<?php }?>
												<td class='left'>
													<div class="image"><img src="<?php echo viewImg($TPL_V2["goods_seq"],'thumbView')?>" width="50"></div>
													<div class="goodsname">
<?php if($TPL_V2["goods_code"]){?><div>[상품코드:<?php echo $TPL_V2["goods_code"]?>]</div><?php }?>
														<div><?php echo $TPL_V2["goods_kind_icon"]?> <a href="/admin/goods/regist?no=<?php echo $TPL_V2["goods_seq"]?>" target="_blank">[<?php echo $TPL_V2["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V2["goods_name"]), 30)?></a></div>
													</div>
												</td>
												<td class='right'><?php echo get_currency_price($TPL_V2["price"], 2)?></td>
											</tr>
<?php }?>
<?php }}?>
										</tbody>
									</table>
								</div>
							</div>	
						</td>
					</tr>
<?php }?>
<?php if($TPL_V1["issuecategorys_sale"]){?>
					<tr>
						<th>카테고리</th>	
						<td class="categoryList">												
								<div class="wx600 category_list">
									<table class="table_basic fix">								
										<thead>
											<tr class="nodrag nodrop">
												<th>카테고리명</th>										
											</tr>
										</thead>
										<tbody>																						
<?php if(is_array($TPL_R2=$TPL_V1["issuecategorys"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["type"]=='sale'){?>
											<tr rownum="<?php echo $TPL_V2["category_code"]?>">
												<td class="center"><?php echo $TPL_V2["title"]?></td>										
											</tr>
<?php }?>
<?php }}?>
										</tbody>
									</table>
								</div>
							</div>
						</td>
					</tr>
<?php }?>
				</tbody>
			</table>					
<?php }?>
			</td>
		</tr>
		<tr>
			<th rowspan="4">추가적립</th>
			<th>조건</th>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<td><?php if($TPL_V1[$TPL_V2["group_seq"]]["point_use"]){?><?php echo $TPL_V1[$TPL_V2["group_seq"]]["point_use"]?><?php }else{?>조건 없음<?php }?></td>
<?php }}?>
		</tr>
		<tr>
			<th>포인트	</th>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<td><?php if($TPL_V1[$TPL_V2["group_seq"]]["point_price"]){?><?php echo $TPL_V1[$TPL_V2["group_seq"]]["point_price"]?> <?php echo $TPL_V1[$TPL_V2["group_seq"]]["point_price_type"]?><?php }else{?>0<?php echo $TPL_VAR["basic_currency"]?> 적립<?php }?></td>
<?php }}?>
		</tr>
		<tr>
			<th>마일리지</th>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<td><?php if($TPL_V1[$TPL_V2["group_seq"]]["reserve_price"]){?><?php echo $TPL_V1[$TPL_V2["group_seq"]]["reserve_price"]?> <?php echo $TPL_V1[$TPL_V2["group_seq"]]["reserve_price_type"]?><?php }else{?>0<?php echo $TPL_VAR["basic_currency"]?> 적립<?php }?></td>
<?php }}?>
		</tr>
		<tr>
			<th>예외</th>
			<td colspan="<?php echo $TPL_V1["gcount"]?>" class="clear" >
<?php if($TPL_V1["issuegoods"]||$TPL_V1["issuecategorys"]){?>
				<table class="table_basic thl v3">									
				<tbody>
<?php if($TPL_V1["issuegoods_emoney"]){?>
					<tr>
						<th>상품</th>								
						<td>
							<div class="wx600 ">
								<div class="goods_list_header">
									<table class="table_basic fix tdc">
										<colgroup>										
<?php if(serviceLimit('H_AD')){?>
											<col width="25%" />
											<col width="55%" />
<?php }else{?>
											<col width="80%" />
<?php }?>
											<col width="20%" />
										</colgroup>
										<tbody>
											<tr>										
<?php if(serviceLimit('H_AD')){?>
											<th>입점사명</th>
<?php }?>
											<th>상품명</th>
											<th>판매가</th>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="goods_list">
									<table class="table_basic fix tdc">
										<colgroup>										
<?php if(serviceLimit('H_AD')){?>
											<col width="25%" />
											<col width="55%" />
<?php }else{?>
											<col width="80%" />
<?php }?>
											<col width="20%" />
										</colgroup>
										<tbody>
											<tr rownum=0 <?php if(count($TPL_V1["issuegoods_emoney"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
												<td class="center" colspan="4">상품을 선택하세요</td>
											</tr><!-- issueGoods, issueGoodsSeq  ==> select_goods_list -->
											
<?php if(is_array($TPL_R2=$TPL_V1["issuegoods"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["type"]=='emoney'){?>
											<tr rownum="<?php echo $TPL_V2["goods_seq"]?>">											
<?php if(serviceLimit('H_AD')){?>
													<td><?php echo $TPL_V2["provider_name"]?></td>
<?php }?>
												<td class='left'>
													<div class="image"><img src="<?php echo viewImg($TPL_V2["goods_seq"],'thumbView')?>" width="50"></div>
													<div class="goodsname">
<?php if($TPL_V2["goods_code"]){?><div>[상품코드:<?php echo $TPL_V2["goods_code"]?>]</div><?php }?>
														<div><?php echo $TPL_V2["goods_kind_icon"]?> <a href="/admin/goods/regist?no=<?php echo $TPL_V2["goods_seq"]?>" target="_blank">[<?php echo $TPL_V2["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V2["goods_name"]), 30)?></a></div>
													</div>
												</td>
												<td class='right'><?php echo get_currency_price($TPL_V2["price"], 2)?></td>
											</tr>
<?php }?>
<?php }}?>
										</tbody>
									</table>
								</div>
							</div>	
						</td>
					</tr>
<?php }?>
<?php if($TPL_V1["issuecategorys_emoney"]){?>
					<tr>
						<th>카테고리</th>	
						<td class="categoryList">												
								<div class="wx600 category_list">
									<table class="table_basic fix">								
										<thead>
											<tr class="nodrag nodrop">
												<th>카테고리명</th>										
											</tr>
										</thead>
										<tbody>																						
<?php if(is_array($TPL_R2=$TPL_V1["issuecategorys"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["type"]=='emoney'){?>
											<tr rownum="<?php echo $TPL_V2["category_code"]?>">
												<td class="center"><?php echo $TPL_V2["title"]?></td>										
											</tr>
<?php }?>
<?php }}?>
										</tbody>
									</table>
								</div>
							</div>
						</td>
					</tr>
<?php }?>
				</tbody>
			</table>					
<?php }?>
			</td>
		</tr>
<?php }}?>
<?php }else{?>
		<tr>
			<td rowspan="8">기본할인<br><button onclick="sale_write();" class="resp_btn v2">수정</button></td>
			<td rowspan="4">추가할인</td>
			<td>조건</td>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<td>조건 없음</td>
<?php }}?>
		</tr>
		<tr>
			<td>할인</td>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<td>0% 할인</td>
<?php }}?>
		</tr>
		<tr>
			<td>추가옵션</td>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<td>0% 할인</td>
<?php }}?>
		</tr>
		<tr>
			<td>예외</td>
			<td colspan="<?php echo $TPL_VAR["gcount"]?>">예외 없음</td>
		</tr>

		<tr>
			<td rowspan="4">추가적립</td>
			<td>조건</td>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<td>조건 없음</td>
<?php }}?>
		</tr>
		<tr>
			<td>포인트	</td>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<td>0% 적립</td>
<?php }}?>
		</tr>
		<tr>
			<td>마일리지</td>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<td>0% 적립</td>
<?php }}?>
		</tr>	
		<tr>
			<td>예외</td>
			<td colspan="<?php echo $TPL_VAR["gcount"]?>">예외 없음</td>
		</tr>
<?php }?>
	</table>
</div>

<!-- paging start -->
<div class="paging_navigation footer">
<?php if($TPL_VAR["page"]["first"]){?>
<a href="/admin/setting/member?gb=member_sale&page=<?php echo $TPL_VAR["page"]["first"]?>">
<input type="button" class="first btn" /></a>&nbsp;
<?php }?>
<?php if($TPL_VAR["page"]["prev"]){?>
<a href="/admin/setting/member?gb=member_sale&page=<?php echo $TPL_VAR["page"]["prev"]?>" class="prev">
<input type="button" class="prev btn" /></a>&nbsp;
<?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["page"]["page"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["page"]["nowpage"]==$TPL_V1){?>
<a class="on red"><?php echo $TPL_V1?></a>&nbsp;
<?php }else{?>
<a href="/admin/setting/member?gb=member_sale&page=<?php echo $TPL_V1?>"><?php echo $TPL_V1?></a>&nbsp;
<?php }?>
<?php }}?>
<?php if($TPL_VAR["page"]["next"]){?>
<a href="/admin/setting/member?gb=member_sale&page=<?php echo $TPL_VAR["page"]["next"]?>" class="next">
<input type="button" class="next btn " /></a>&nbsp;
<?php }?>
<?php if($TPL_VAR["page"]["last"]){?>
<a href="/admin/setting/member?gb=member_sale&page=<?php echo $TPL_VAR["page"]["last"]?>"><input type="button" class="end btn" /></a>
<?php }?>
</div>
<!-- paging end -->
<div style="padding-top:30px;"></div>

<div id="grade_help" style="display:none;">
	<table width="100%" class="info-table-style">
		<col width="70" /><col width="70" /><col width="80" /><col width="160" /><col width="" />
		<tr>
			<th class="its-th-align center" colspan="3">세트 종류</th>
			<th class="its-th-align" colspan="2">등급 별 세팅안내</th>
		</tr>
		<tr>
			<td rowspan="8" class="its-td-align center">세트명</td>
			<td rowspan="4" class="its-td-align center">추가할인</td>
			<td class="its-td-align center">조건</td>
			<td class="its-td-align left" style="padding-left:5px;">얼마 이상 구매 시 추가 할인</td>
			<td class="its-td-align left" style="padding-left:5px;">조건 구매금액 계산식 : 구매금액 = <span style="color:red;">&#123;상품 할인가(판매가) x 수량&#125;+&#123;좌동&#125;+&#123;좌동&#125;</span></td>
		</tr>
		<tr>
			<td class="its-td-align center">할인</td>
			<td class="its-td-align left" style="padding-left:5px;">기본 상품의 추가 할인금액</td>
			<td class="its-td-align left" style="padding-left:5px;">상품별 추가 할인금액 계산식 : 상품 추가할인 금액 = 상품 할인가(판매가) x 수량 x 할인%</td>
		</tr>
		<tr>
			<td class="its-td-align center">추가옵션</td>
			<td class="its-td-align left" style="padding-left:5px;">추가 상품의 추가 할인금액</td>
			<td class="its-td-align left" style="padding-left:5px;">추가 상품별 추가 할인금액 계산식 : 추가 상품 추가할인 금액 = 추가 상품 할인가(판매가) x 수량 x 할인%</td>
		</tr>
		<tr>
			<td class="its-td-align center">예외</td>
			<td class="its-td-align left" style="padding-left:5px;">추가할인 제외 상품</td>
			<td class="its-td-align left" style="padding-left:5px;">추가 할인이 적용되지 않아야 하는 예외 상품을 상품 또는 카테고리로 선정하여 등록할 수 있습니다.</td>
		</tr>
		<tr>
			<td rowspan="4" class="its-td-align center">추가적립</td>
			<td class="its-td-align center">조건</td>
			<td class="its-td-align left" style="padding-left:5px;">얼마 이상 구매 시 추가 적립</td>
			<td class="its-td-align left" style="padding-left:5px;">조건 구매금액 계산식 : 구매금액 = <span style="color:red;">&#123;상품 할인가(판매가) x 수량&#125;+&#123;좌동&#125;+&#123;좌동&#125;</span></td>
		</tr>
		<tr>
			<td class="its-td-align center">마일리지</td>
			<td class="its-td-align left" style="padding-left:5px;">추가 마일리지 금액</td>
			<td class="its-td-align left" style="padding-left:5px;">상품별 추가 마일리지 계산식 : 추가 마일리지 금액 = 상품 실결제금액 x 추가마일리지%<br>※ 상품 실결제금액 = <span style="color:red;">&#123;상품 할인가(판매가) x 수량&#125;</span> – 할인(쿠폰/프로모션코드/등급/Like/모바일)</td>
		</tr>
		<tr>
			<td class="its-td-align center">포인트</td>
			<td class="its-td-align left" style="padding-left:5px;">추가 포인트 금액</td>
			<td class="its-td-align left" style="padding-left:5px;">상품별 추가 포인트 계산식 : 추가 포인트 금액 = 상품 실결제금액 x 추가포인트%<br>※ 상품 실결제금액 = <span style="color:red;">&#123;상품 할인가(판매가) x 수량&#125;</span> – 할인(쿠폰/프로모션코드/등급/Like/모바일)</td>
		</tr>
		<tr>
			<td class="its-td-align center">예외</td>
			<td class="its-td-align left" style="padding-left:5px;">추가적립 제외 상품</td>
			<td class="its-td-align left" style="padding-left:5px;">추가 할인이 적용되지 않아야 하는 예외 상품을 상품 또는 카테고리로 선정하여 등록할 수 있습니다.</td>
		</tr>
	</table>
</div>

<div id="gradePopup"></div>
<div id="PaymentPopup" class="hide"></div>
<div id="AddLimitPopup" class="hide">
	이용 가능한 '잔여 혜택 세트'가 <?php echo $TPL_VAR["config_system"]["service"]["max_member_sale_cnt"]-$TPL_VAR["use_member_sale_cnt"]?> 입니다.<br/>
	이용 가능한 혜택 세트를 추가해 주시길 바랍니다.
	<div style="width:100%;text-align:center;margin-top:20px;"><span class="btn large cyanblue"><input type="button" value="혜택 세트 추가"  <?php if($TPL_VAR["functionLimit"]){?>  onclick="servicedemoalert('use_f');" <?php }else{?> onclick="member_sale_payment();" <?php }?> style="width:100px;"></span><div>
</div>
<div id="goodsSelectMethod" class="hide">
	<center>
		<img src="/admin/skin/default/images/design/bnfset_i_slct.gif">
	</center>
</div>