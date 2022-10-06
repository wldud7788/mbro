<?php /* Template_ 2.2.6 2022/05/17 12:37:01 /www/music_brother_firstmall_kr/admin/skin/default/setting/search.html 000014616 */ 
$TPL_cfg_search_word_1=empty($TPL_VAR["cfg_search_word"])||!is_array($TPL_VAR["cfg_search_word"])?0:count($TPL_VAR["cfg_search_word"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript">

	// 도로명 주소 설정 표시
	function check_zipcode_street(){
		$("table#zipcode_street_table").find("input.zipcode_street").each(function(){
			if( $(this).attr("checked") ){
				$(this).closest("label").addClass('bold');
			}else{
				$(this).closest("label").removeClass('bold');
			}
		});
	}

	function check_bg_color(){
		$("tr.page-search-keyword td input[type='checkbox']").each(function(){
			
			if( $(this).prop('checked') ){
				var row_item = $(this).closest("tr").find('input[name="row_item"]').val();

				$(this).closest("table").css("background-color", "#ffffff");

			}else{
				var row_item = $(this).closest("tr").find('input[name="row_item"]').val();

				$(this).closest("table").css("background-color", "#fafafa");
			}
		});
	}

	function check_all_page(bObj){
		var obj  = $(bObj);
		if( obj.prop('checked') ){
			$("tr.page-search-keyword td input[type='checkbox']").each(function(){
				$(this).prop('checked',true);
			});
		}else{
			$("tr.page-search-keyword td input[type='checkbox']").each(function(){
				$(this).prop('checked',false);
			});
		}
		check_bg_color();
	}

	$(document).ready(function() {
		
		$(".btn_plus").on("click",function(){
			if( $(this).closest("table").find("tr").length < 10){ 
				var clone = $(this).closest("tr").clone();			
				clone.find(".btn_plus").addClass("btn_minus").removeClass("btn_plus");    	
				clone.find(".search_result_link").attr("title",'검색어');    	
				clone.find(".search_result_link").val('');
				$(this).closest("table").append(clone);    	 	
				$(this).closest("table").find(".pagetd").attr("rowspan",$(this).closest("table").find("tr").length);
				clone.find(".pagetd").remove();
				
				setDefaultText();
			}

			$(".btn_minus").on("click",function(){
				$(this).closest("tr").remove();
			});
		});

		$(".btn_minus").on("click",function(){
			
			$(this).closest("tr").remove();
		});

		$(".search_result").on("change",function(){
			if( $(this).val() == 'direct' ) title = "링크 주소(URL)";
			else title = "검색어";
			$(this).closest("tr").find(".search_result_link").val('');
			$(this).closest("tr").find(".search_result_link").attr("title",title);
			setDefaultText();
		});

		$("input[name=popular_search]").on("click", function(){
			if($(this).val()=='y')
			{
				$(".timeSetting").show()
			}else{
				$(".timeSetting").hide()
			}
			
		});

		// 도로명 주소 설정 표시
		$("table#zipcode_street_table").find("input.zipcode_street").change(function(){
			check_zipcode_street();
		});

		check_zipcode_street();

		check_bg_color();

		// 체크박스 이벤트 추가
		$('.chk_list').click(function(){
			check_bg_color();
		});

<?php if($TPL_VAR["cfg_search"]["popular_search"]=='y'){?>		
			$(".timeSetting").show()
<?php }else{?>
			$(".timeSetting").hide()
<?php }?>
	});
</script>

<style>
/*레이어팝업*/
.layer_pop {border:3px solid #618298; background:#fff;}
.layer_pop .tit {height:45px; font:14px Dotum; letter-spacing:-1px; font-weight:bold; color:#003775; background:#ebf4f2; border-bottom:1px solid #d8dee3; padding:0 10px; border-right:0;}
.layer_pop .search_input {border:1px solid #cecece; height:17px;}
.layer_pop .left {text-align:left;}
table.info-table-style tr td.top {vertical-align:top;}
.table_list > table{margin-top:-1px;}
</style>

<form name="settingForm" method="post" enctype="multipart/form-data" action="../setting_process/search" target="actionFrame">
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar" class="gray-bar">
<?php $this->print_("require_info",$TPL_SCP,1);?>


		<!-- 타이틀 -->
		<div class="page-title">
			<h2>검색</h2>
		</div>

		<!-- 우측 버튼 -->
		<div class="page-buttons-right">
			<button class="resp_btn active2 size_L" type="submit">저장</button>
		</div>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<div class="contents_container">
	<!-- 서브메뉴 바디 : 시작-->
<?php if(serviceLimit('H_NFR')){?>
	<div class="contents_dvs">
		<div class="item-title">
			검색창 기본 검색어
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/search', '#tip1')"></span>
			<span class="desc">페이지별 기본 검색어를 설정합니다.</span>
		</div>
		
		<div class="table_list">
			<table class="table_basic">			
				<col width="5%" /><col width="20%" /><col width="20%" /><col width="50%" /><col width="5%" />
				<thead>
					<tr>
						<th>사용</th>
						<th>페이지</th>
						<th>검색창 표기</th>
						<th>연결 페이지</th>
						<th>추가</th>
					</tr>
				</thead>
			</table>
			
<?php if($TPL_cfg_search_word_1){foreach($TPL_VAR["cfg_search_word"] as $TPL_K1=>$TPL_V1){?>
			<table width="100%" class="table_basic v5">
				<col width="5%" /><col width="20%" /><col width="20%" /><col width="50%" /><col width="5%" />
<?php if($TPL_VAR["result"][$TPL_K1]){?>
<?php if(is_array($TPL_R2=$TPL_VAR["result"][$TPL_K1])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>			
				<tr class="page-search-keyword">
<?php if($TPL_I2== 0){?>
					<td class="center pagetd" rowspan="<?php echo count($TPL_VAR["result"][$TPL_K1])?>">					
						<label class="resp_checkbox"><input type="checkbox" class="chk_list" name="page_yn[<?php echo $TPL_K1?>]" value="y" <?php if($TPL_V2["page_yn"]=='y'){?>checked<?php }?>></label>					
						<input type="hidden" name="page[<?php echo $TPL_K1?>]" value="1">
						<input type="hidden" name="row_item" value="row_item<?php echo $TPL_K1?>">
					</td>
					<td class="pagetd" rowspan="<?php echo count($TPL_VAR["result"][$TPL_K1])?>"><?php echo $TPL_V1?></td>
<?php }?>				
					<td>							
						<input type="text" class="row_item<?php echo $TPL_K1?>" name="keyword[<?php echo $TPL_K1?>][]" value="<?php echo $TPL_V2["word"]?>" size="28" title="" />
					</td>
					<td>
						<select name="search_result[<?php echo $TPL_K1?>][]" class="search_result row_item<?php echo $TPL_K1?>">
							<option value="search" <?php if($TPL_V2["search_result"]=='search'){?>selected<?php }?>>검색결과페이지</option>
							<option value="direct" <?php if($TPL_V2["search_result"]=='direct'){?>selected<?php }?>>직접입력</option>
						</select>
									
						<input type="text" name="search_result_link[<?php echo $TPL_K1?>][]" value="<?php echo $TPL_V2["search_result_link"]?>" size="55" title="검색어" class="search_result_link row_item<?php echo $TPL_K1?>">
						<select name="search_result_target[<?php echo $TPL_K1?>][]" class="row_item<?php echo $TPL_K1?>">
							<option value="_self" <?php if($TPL_V2["search_result_target"]=='_self'){?>selected<?php }?>>현재창</option>
							<option value="_blank" <?php if($TPL_V2["search_result_target"]=='_blank'){?>selected<?php }?>>새창</option>
						</select>					
					</td>		
					<td class="center">
<?php if($TPL_I2> 0){?>
						<button type="button" class="btn_minus"></button>
<?php }else{?>
						<button type="button" class="btn_plus"></button>
<?php }?>
					</td>
				</tr>
<?php }}?>
<?php }else{?>
				<tr class="page-search-keyword">
					<td class="center pagetd">					
						<label class="resp_checkbox"><input type="checkbox" name="page_yn[<?php echo $TPL_K1?>]"  class="chk_list" value="y" ></label> 					
						<input type="hidden" name="page[<?php echo $TPL_K1?>]" value="1">
						<input type="hidden" name="row_item" value="row_item<?php echo $TPL_K1?>">
					</td>
					<td class="pagetd"><?php echo $TPL_V1?></td>
					<td>					
						<input type="text" class="row_item<?php echo $TPL_K1?>" name="keyword[<?php echo $TPL_K1?>][]" value="" size="28" title="" />
					</td>
					<td>
						<select name="search_result[<?php echo $TPL_K1?>][]" class="search_result row_item<?php echo $TPL_K1?>">
							<option value="search">검색결과페이지</option>
							<option value="direct">직접입력</option>
						</select>
									
						<input type="text" name="search_result_link[<?php echo $TPL_K1?>][]" value="" size="55" title="검색어" class="search_result_link row_item<?php echo $TPL_K1?>">
						<select name="search_result_target[<?php echo $TPL_K1?>][]" class="row_item<?php echo $TPL_K1?>">
							<option value="_self">현재창</option>
							<option value="_blank">새창</option>
						</select>					
					</td>		
					<td class="center">
						<button type="button" class="btn_plus"></button>
					</td>
				</tr>
<?php }?>
			</table>
<?php }}?>	
		</div>
	</div>
<?php if($TPL_VAR["config_system"]["operation_type"]!='light'){?>
	<div class="contents_dvs">
		<div class="item-title">
			인기 검색어
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/search', '#tip2')"></span>
		</div>

		<table class="table_basic thl">
			<tr>
				<th>인기 검색어</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="popular_search" value="y" <?php if($TPL_VAR["cfg_search"]["popular_search"]=='y'){?>checked<?php }?> > 사용함</label>
						<label><input type="radio" name="popular_search" value="n" <?php if($TPL_VAR["cfg_search"]["popular_search"]=='n'||$TPL_VAR["cfg_search"]["popular_search"]==''){?>checked<?php }?> > 사용 안 함</label>
					</div>
				</td>
			</tr>

			<tr class="timeSetting">
				<th>
					인기검색어 기간						
				</th>
				<td>
					최근 
					<select name="popular_search_limit_day">
						<option value="15" <?php if($TPL_VAR["cfg_search"]["popular_search_limit_day"]=='15'){?>selected<?php }?>>15</option>
						<option value="30" <?php if($TPL_VAR["cfg_search"]["popular_search_limit_day"]=='30'){?>selected<?php }?>>30</option>
						<option value="60" <?php if($TPL_VAR["cfg_search"]["popular_search_limit_day"]=='60'){?>selected<?php }?>>60</option>
						<option value="90" <?php if($TPL_VAR["cfg_search"]["popular_search_limit_day"]=='90'){?>selected<?php }?>>90</option>
					</select>
					일 동안 가장 많이 검색된 검색어
				</td>
			</tr>

			<tr>
				<th>
					추천 상품
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/search', '#tip3', 'sizeM')"></span>
				</th>
				<td>
					최근
					<select name="popular_search_recomm_limit_day">
						<option value="15" <?php if($TPL_VAR["cfg_search"]["popular_search_recomm_limit_day"]=='15'){?>selected<?php }?>>15일</option>
						<option value="30" <?php if($TPL_VAR["cfg_search"]["popular_search_recomm_limit_day"]=='30'){?>selected<?php }?>>30일</option>
						<option value="60" <?php if($TPL_VAR["cfg_search"]["popular_search_recomm_limit_day"]=='60'){?>selected<?php }?>>60일</option>
						<option value="90" <?php if($TPL_VAR["cfg_search"]["popular_search_recomm_limit_day"]=='90'){?>selected<?php }?>>90일</option>
					</select>
					일 동안 판매된 상품 제공
				</td>
			</tr>
		</table>
	</div>

	<div class="contents_dvs">
		<div class="item-title">
			검색어 자동 완성
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/search', '#tip4')"></span>
		</div>

		<table class="table_basic thl">
			<tr>
				<th>검색어 자동 완성</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="auto_search" value="y" <?php if($TPL_VAR["cfg_search"]["auto_search"]=='y'){?>checked<?php }?> > 사용함</label>
						<label><input type="radio" name="auto_search" value="n" <?php if($TPL_VAR["cfg_search"]["auto_search"]=='n'||$TPL_VAR["cfg_search"]["auto_search"]==''){?>checked<?php }?> > 사용 안 함</label>
					</div>
				</td>
			</tr>

			<tr>
				<th>
					추천 상품
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/search', '#tip5', 'sizeM')"></span>
				</th>
				<td>
					최근
					<select name="auto_search_recomm_limit_day">
						<option value="15" <?php if($TPL_VAR["cfg_search"]["auto_search_recomm_limit_day"]=='15'){?>selected<?php }?>>15일</option>
						<option value="30" <?php if($TPL_VAR["cfg_search"]["auto_search_recomm_limit_day"]=='30'){?>selected<?php }?>>30일</option>
						<option value="60" <?php if($TPL_VAR["cfg_search"]["auto_search_recomm_limit_day"]=='60'){?>selected<?php }?>>60일</option>
						<option value="90" <?php if($TPL_VAR["cfg_search"]["auto_search_recomm_limit_day"]=='90'){?>selected<?php }?>>90일</option>
					</select>
					일 동안 판매된 상품 제공
				</td>
			</tr>
		</table>
	</div>
<?php }?>
<?php }?>
<?php if($TPL_VAR["config_system"]["operation_type"]!='light'){?>
	<div class="contents_dvs">
		<div class="item-title">주소 검색</div>
		<table class="table_basic thl">
			<tr>
				<th>주소 검색 창 설정</th>
				<td>
					<ul class="ul_list_08 resp_checkbox">
						<li>
							<label><input type="checkbox" name="street_zipcode_5" class="zipcode_street" value="1" <?php if($TPL_VAR["cfg_zipcode"]["street_zipcode_5"]){?>checked<?php }?> /> 신우편번호(5자리)로 도로명(지번) 검색.</label>
						</li>
						<li>
							<label><input type="checkbox" name="street_zipcode_6"  class="zipcode_street" value="1" <?php if($TPL_VAR["cfg_zipcode"]["street_zipcode_6"]){?>checked<?php }?> /> 구우편번호(6자리)로 도로명(지번) 검색.</label>
						</li>
						<li>
							<label><input type="checkbox" name="old_zipcode_lot_number"  class="zipcode_street" value="1" <?php if($TPL_VAR["cfg_zipcode"]["old_zipcode_lot_number"]){?>checked<?php }?> /> 구우편번호(6자리)로  (구)지번 검색</label>
							<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/search', '#tip6')"></span>
						</li>
					</ul>
					<ul class="bullet_hyphen">
						<li>주소 검색은 최소 1개 이상 선택해야 합니다.</li>							
					</ul>
				</td>
			</tr>			
		</table>
	</div>
<?php }?>
	<div id="html_error"></div>
	<!-- 서브메뉴 바디 : 끝 -->
<!-- 서브 레이아웃 영역 : 끝 -->
</form>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>