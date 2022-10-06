<?php /* Template_ 2.2.6 2022/05/17 12:31:52 /www/music_brother_firstmall_kr/admin/skin/default/goods/restock_notify_catalog.html 000030622 */ 
$TPL_model_1=empty($TPL_VAR["model"])||!is_array($TPL_VAR["model"])?0:count($TPL_VAR["model"]);
$TPL_brand_1=empty($TPL_VAR["brand"])||!is_array($TPL_VAR["brand"])?0:count($TPL_VAR["brand"]);
$TPL_manufacture_1=empty($TPL_VAR["manufacture"])||!is_array($TPL_VAR["manufacture"])?0:count($TPL_VAR["manufacture"]);
$TPL_orign_1=empty($TPL_VAR["orign"])||!is_array($TPL_VAR["orign"])?0:count($TPL_VAR["orign"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php if($_GET["scriptPaging"]!='y'){?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<?php }?>

<script type="text/javascript">
<?php if($_GET["scriptPaging"]!='y'){?>
	//기본검색설정
	var default_search_pageid	= "restock_notify_catalog";
	var default_obj_width		= 750;
	var default_obj_height		= 500;
<?php }?>

	// SEARCH FOLDER
	function showSearch(){
		if($("#goods_search_form").css('display')=='none'){
			$("#goods_search_form").show();
			$.cookie("goods_list_folder", "folded");
		}else{
			$("#goods_search_form").hide();
			$.cookie("goods_list_folder", "unfolded");
		}
	}


	$(document).ready(function() {

		//기본검색설정 카테고리 선택값
		default_select_category1	= '';
		default_select_category2	= '';
		default_select_category3	= '';
		default_select_category4	= '';
		default_select_brands1		= '';
		default_select_brands2		= '';
		default_select_brands3		= '';
		default_select_brands4		= '';
<?php if($TPL_VAR["sc"]["category1"]){?>default_select_category1	= '<?php echo $_GET["category1"]?>';<?php }?>
<?php if($TPL_VAR["sc"]["category2"]){?>default_select_category2	= '<?php echo $_GET["category2"]?>';<?php }?>
<?php if($TPL_VAR["sc"]["category3"]){?>default_select_category3	= '<?php echo $_GET["category3"]?>';<?php }?>
<?php if($TPL_VAR["sc"]["category4"]){?>default_select_category4	= '<?php echo $_GET["category4"]?>';<?php }?>
<?php if($TPL_VAR["sc"]["brands1"]){?>default_select_brands1	= '<?php echo $_GET["category1"]?>';<?php }?>
<?php if($TPL_VAR["sc"]["brands2"]){?>default_select_brands2	= '<?php echo $_GET["category2"]?>';<?php }?>
<?php if($TPL_VAR["sc"]["brands3"]){?>default_select_brands3	= '<?php echo $_GET["category3"]?>';<?php }?>
<?php if($TPL_VAR["sc"]["brands4"]){?>default_select_brands4	= '<?php echo $_GET["category4"]?>';<?php }?>

		// CHECKBOX
		$("input:[name='restock_notify_seq[]']").click(function(){
			chkMemberCount();
		});

		// SMS
		$("#sms_form").click(function(){
<?php if(!$TPL_VAR["auth"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>
			$("#container").css("height","0px");
			$("#container").attr("src","../member/sms_form?table=fm_goods_restock_notify");
			$("#container").show();

			$(document).scrollTop($("#container").offset().top);
		});

		/* 카테고리 불러오기 */
		category_admin_select_load('','category1','',function(){
<?php if($TPL_VAR["sc"]["category1"]){?>
			$("select[name='category1']").val('<?php echo $_GET["category1"]?>').change();
<?php }?>
		});
		$("select[name='category1']").live("change",function(){
			category_admin_select_load('category1','category2',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["category2"]){?>
				$("select[name='category2']").val('<?php echo $_GET["category2"]?>').change();
<?php }?>
			});
			category_admin_select_load('category2','category3',"");
			category_admin_select_load('category3','category4',"");
		});
		$("select[name='category2']").live("change",function(){
			category_admin_select_load('category2','category3',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["category3"]){?>
				$("select[name='category3']").val('<?php echo $_GET["category3"]?>').change();
<?php }?>
			});
			category_admin_select_load('category3','category4',"");
		});
		$("select[name='category3']").live("change",function(){
			category_admin_select_load('category3','category4',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["category4"]){?>
				$("select[name='category4']").val('<?php echo $_GET["category4"]?>').change();
<?php }?>
			});
		});
		////////////////////////////

		/* 브랜드 불러오기 */
		brand_admin_select_load('','brands1','',function(){
<?php if($TPL_VAR["sc"]["brands1"]){?>
			$("select[name='brands1']").val('<?php echo $_GET["brands1"]?>').change();
<?php }?>
		});
		$("select[name='brands1']").live("change",function(){
			brand_admin_select_load('brands1','brands2',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["brands2"]){?>
				$("select[name='brands2']").val('<?php echo $_GET["brands2"]?>').change();
<?php }?>
			});
			brand_admin_select_load('brands2','brands3',"");
			brand_admin_select_load('brands3','brands4',"");
		});
		$("select[name='brands2']").live("change",function(){
			brand_admin_select_load('brands2','brands3',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["brands3"]){?>
				$("select[name='brands3']").val('<?php echo $_GET["brands3"]?>').change();
<?php }?>
			});
			brand_admin_select_load('brands3','brands4',"");
		});
		$("select[name='brands3']").live("change",function(){
			brand_admin_select_load('brands3','brands4',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["brands4"]){?>
				$("select[name='brands1']").val('<?php echo $_GET["brands1"]?>').change();
<?php }?>
			});
		});

		// SMS
		$("#restock_sms_form").click(function(){
<?php if(!$TPL_VAR["auth_send"]){?>
			alert("권한이 없습니다.");
			return;
<?php }else{?>
			var screenWidth;
			var screenHeight;

			screenWidth = screen.width;
			screenHeight = screen.height;
			
			if(screenWidth > 1250) screenWidth = "1250";
			if(screenHeight > 1024) screenHeight = "1024";

			
			window.open('../batch/restock_notify_sms',"sms_form","menubar=no, toolbar=no, location=yes, status=no, resizble=yes, scrollbars=yes,width=" + screenWidth + ", height=" + screenHeight);
<?php }?>
		});

		$("#delete_btn").click(function(){
<?php if(!$TPL_VAR["auth"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>

			var cnt = $("input:checkbox[name='restock_notify_seq[]']:checked").length;
			if(cnt<1){
				alert("삭제할 상품을 선택해 주세요.");
				return;
			}else{
				var queryString = $("#memberForm").serialize();
				if(!confirm("선택한 신청내역을 삭제 시키겠습니까? ")) return;
				$.ajax({
					type: "get",
					url: "../goods_process/restock_notify_delete",
					data: queryString,
					success: function(result){
						//alert(result);
						location.reload();
					}
				});
			}
		});

		$("#chkAll").click(function(){
			if($(this).attr("checked")){
				$(".chk").attr("checked",true).change();
			}else{
				$(".chk").attr("checked",false).change();
			}
		});

		// 체크박스 색상
		$("input[type='checkbox'][name='goods_seq[]']").live('change',function(){
			if($(this).is(':checked')){
				$(this).closest('tr').addClass('checked-tr-background');
			}else{
				$(this).closest('tr').removeClass('checked-tr-background');
			}
		}).change();



	});

	//MEMBER DETAIL
	function viewDetail(seq){
		//if(!$(obj).attr('member_seq')) return;
		//location.href = "detail?member_seq="+$(obj).attr('member_seq');

		$("input[name='member_seq']").val(seq);
		$("form[name='memberForm']").attr('action','../member/detail');
		$("form[name='memberForm']").submit();
	}

	//CHECKBOX COUNT - IFRAME CONTROLLER
	function chkMemberCount(){
		var cnt = $("input:checkbox[name='restock_notify_seq[]']:checked").length;
		$("#container").contents().find("#selected_member").html(cnt);

	}

	function searchMemberCount(){
		var cnt = $("input[name='searchcount']").val();
		$("#container").contents().find("#search_member").html(cnt);

	}

	function chkAll(chk, name){
		if(chk.checked){
			$("."+name).attr("checked",true).change();
		}else{
			$("."+name).attr("checked",false).change();
		}

	}
</script>

<form name="memberForm" id="memberForm">
<input type="hidden" name="scriptPaging" value="<?php echo $_GET["scriptPaging"]?>" />
<input type="hidden" name="member_seq" value=""/>
<input type="hidden" name="org_keyword" value="<?php echo $_GET["keyword"]?>"/>

<?php if($_GET["scriptPaging"]!='y'){?>
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>재입고알림 요청 상품 리스트</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<!--li><span class="btn large orange"><button type="button" id="delete_btn">삭제</button></span></li-->
			<li><span class="btn large orange"><button type="button" id="restock_sms_form">재입고알림 통보하기</button></span></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
		
		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->
<?php }?>

<input type="hidden" name="query_string"/>
<input type="hidden" name="searchcount" value="<?php echo $TPL_VAR["page"]["totalcount"]?>"/>
<input type="hidden" name="no" />

<!-- 주문리스트 검색폼 : 시작 -->
<div class="search-form-container">
	<table class="search-form-table">
		<tr>
			<td>
				<table>
					<tr>
						<td width="440">
							<table class="sf-keyword-table">
							<tr>
								<td class="sfk-td-txt"><input type="text" name="keyword" value="<?php echo $_GET["keyword"]?>" title="상품명, 상품코드" /></td>
								<td class="sfk-td-btn"><button <?php if($_GET["scriptPaging"]=='y'){?>type="button" onclick="searchSubmit();"<?php }else{?>type="submit"<?php }?>><span>검색</span></button></td>
							</tr>
							</table>
						</td>
						<td width="20">&nbsp;</td>
						<td>
						<span id="set_default_button" class="icon-arrow-down" style="cursor:pointer;">기본검색설정</span>&nbsp;
						<span class="btn small gray"><button type="button" onclick="set_search_form('restock_notify_catalog')">적용 ▶</button></span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table class="search-form-table" id="search_detail_table">
		<tr id="goods_search_form" style="display:block;">
		<tr>
			<td>
				<table class="sf-option-table">
					<colgroup>
						<col width="80" /><col width="300" />
						<col width="90" /><col />
					</colgroup>
					<tr>
						<th>카테고리</th>
						<td colspan="5">
							<select class="line" name="category1" size="1" style="width:100px;"><option value="">= 1차 분류 =</option></select>
							<select class="line" name="category2" size="1" style="width:100px;"><option value="">= 2차 분류 =</option></select>
							<select class="line" name="category3" size="1" style="width:100px;"><option value="">= 3차 분류 =</option></select>
							<select class="line" name="category4" size="1" style="width:100px;"><option value="">= 4차 분류 =</option></select>&nbsp;
							<label><input type="checkbox" name="search_link_category" value="1" <?php if($_GET["search_link_category"]){?>checked="checked"<?php }?> /> 대표
							<span class="helpicon" title='체크 시 대표 카테고리를 기준으로 검색됩니다.'></span></label>
						</td>
					</tr>
					<tr>
						<th>브랜드</th>
						<td colspan="5">
							<select class="line" name="brands1" size="1" style="width:100px;"><option value="">= 1차 분류 =</option></select>
							<select class="line" name="brands2" size="1" style="width:100px;"><option value="">= 2차 분류 =</option></select>
							<select class="line" name="brands3" size="1" style="width:100px;"><option value="">= 3차 분류 =</option></select>
							<select class="line" name="brands4" size="1" style="width:100px;"><option value="">= 4차 분류 =</option></select>&nbsp;
							<label><input type="checkbox" name="search_link_brand" value="1" <?php if($_GET["search_link_brand"]){?>checked="checked"<?php }?> /> 대표
							<span class="helpicon" title='체크 시 대표 브랜드를 기준으로 검색됩니다.'></span></label>
						</td>
					</tr>
					<tr>
						<th>
							<select name="date_gb" class="search_select line" default_none>
								<option value="regist_date" <?php if($TPL_VAR["sc"]["date_gb"]=='regist_date'){?>selected<?php }?>>등록일</option>
								<!--<option value="update_date" <?php if($TPL_VAR["sc"]["date_gb"]=='update_date'){?>selected<?php }?>>수정일</option>-->
							</select>
						</th>
						<td colspan="5">
							<input type="text" name="sdate" value="<?php echo $_GET["sdate"]?>" class="datepicker line"  maxlength="10" size="10" default_none />
							&nbsp;<span class="gray">-</span>&nbsp;
							<input type="text" name="edate" value="<?php echo $_GET["edate"]?>" class="datepicker line" maxlength="10" size="10" default_none />
							&nbsp;&nbsp;
							<span class="btn small"><input type="button" value="오늘" id="today" class="select_date"/></span>
							<span class="btn small"><input type="button" value="3일간" id="3day" class="select_date"/></span>
							<span class="btn small"><input type="button" value="일주일" id="1week" class="select_date"/></span>
							<span class="btn small"><input type="button" value="1개월" id="1month" class="select_date"/></span>
							<span class="btn small"><input type="button" value="3개월" id="3month" class="select_date"/></span>
							<span class="btn small"><input type="button" value="전체" id="all" class="select_date"/></span>
						</td>
					</tr>
					<tr>
						<th><select name="price_gb" class="search_select line" default_none>
								<option value="consumer_price" <?php if($TPL_VAR["sc"]["price_gb"]=='consumer_price'){?>selected<?php }?>>정상가</option>
								<option value="price" <?php if($TPL_VAR["sc"]["price_gb"]=='price'){?>selected<?php }?>>할인가</option>
							</select></th>
						<td no=0>
							<input type="text" name="sprice" value="<?php echo $_GET["sprice"]?>" size="7" class="line onlyfloat" row_group="price"/> - <input type="text" name="eprice" value="<?php echo $_GET["eprice"]?>" size="7" class="line onlyfloat" row_group="price"/>
						</td>
						<th>재고수량</th>
						<td no=1>
							<input type="text" name="sstock" value="<?php echo $_GET["sstock"]?>" size="7" class="line onlynumber" row_group="stock"/> - <input type="text" name="estock" value="<?php echo $_GET["estock"]?>" size="7" class="line onlynumber" row_group="stock"/>
						</td>
					</tr>
					<tr>
						<!--
						<th>매입처</th>
						<td>
							<select name=""></select>
						</td>
						<th>판매처</th>
						<td>
							<select name=""></select>
						</td>
						
						<th>모델명</th>
						<td>
							<select name="model" class="line">
								<option value="">= 선택하세요 =</option>
<?php if($TPL_model_1){foreach($TPL_VAR["model"] as $TPL_V1){?>
<?php if($TPL_V1["contents"]){?>
								<option value="<?php echo $TPL_V1["contents"]?>" <?php if($TPL_VAR["sc"]["model"]==$TPL_V1["contents"]){?>selected<?php }?>><?php echo $TPL_V1["contents"]?></option>
<?php }?>
<?php }}?>
							</select>
						</td>
						<th>브랜드</th>
						<td>
							<select name="brand" class="line">
								<option value="">= 선택하세요 =</option>
<?php if($TPL_brand_1){foreach($TPL_VAR["brand"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["contents"]?>" <?php if($TPL_VAR["sc"]["brand"]==$TPL_V1["contents"]){?>selected<?php }?>><?php echo $TPL_V1["contents"]?></option>
<?php }}?>
							</select>
						</td>
						-->
						<th>상태</th>
						<td no=0>
							<label><input type="checkbox" name="goodsStatus[]" value="normal" <?php if($TPL_VAR["sc"]["goodsStatus"]&&in_array('normal',$TPL_VAR["sc"]["goodsStatus"])){?>checked<?php }?>/> <span>정상</span></label>
							<label><input type="checkbox" name="goodsStatus[]" value="runout" <?php if($TPL_VAR["sc"]["goodsStatus"]&&in_array('runout',$TPL_VAR["sc"]["goodsStatus"])){?>checked<?php }?>/> <span>품절</span></label>
							<label><input type="checkbox" name="goodsStatus[]" value="purchasing" <?php if($TPL_VAR["sc"]["goodsStatus"]&&in_array('purchasing',$TPL_VAR["sc"]["goodsStatus"])){?>checked<?php }?>/> <span>재고확보중</span></label>
							<label><input type="checkbox" name="goodsStatus[]" value="unsold" <?php if($TPL_VAR["sc"]["goodsStatus"]&&in_array('unsold',$TPL_VAR["sc"]["goodsStatus"])){?>checked<?php }?>/> <span>판매중지</span></label>
						</td>
						<th>재입고알림</th>
						<td no=1 >
							<label><input type="checkbox" name="notifyStatus[]" value="none" <?php if($TPL_VAR["sc"]["notifyStatus"]&&in_array('none',$TPL_VAR["sc"]["notifyStatus"])){?>checked<?php }?>/> <span>미통보</span></label>
							<label><input type="checkbox" name="notifyStatus[]" value="complete" <?php if($TPL_VAR["sc"]["notifyStatus"]&&in_array('complete',$TPL_VAR["sc"]["notifyStatus"])){?>checked<?php }?>/> <span>통보</span></label>
						</td>
					</tr>
					<tr>
					<!--
						<th>제조사</th>
						<td>
							<select name="manufacture" class="line">
								<option value="">= 선택하세요 =</option>
<?php if($TPL_manufacture_1){foreach($TPL_VAR["manufacture"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["contents"]?>" <?php if($TPL_VAR["sc"]["manufacture"]==$TPL_V1["contents"]){?>selected<?php }?>><?php echo $TPL_V1["contents"]?></option>
<?php }}?>
							</select>
						</td>
						<th>원산지</th>
						<td>
							<select name="orign" class="line">
								<option value="">= 선택하세요 =</option>
<?php if($TPL_orign_1){foreach($TPL_VAR["orign"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["contents"]?>" <?php if($TPL_VAR["sc"]["orign"]==$TPL_V1["contents"]){?>selected<?php }?>><?php echo $TPL_V1["contents"]?></option>
<?php }}?>
							</select>
						</td>
						-->
						<th>노출</th>
						<td>
							<label><input type="checkbox" name="goodsView[]" value="look" <?php if($TPL_VAR["sc"]["goodsView"]&&in_array('look',$TPL_VAR["sc"]["goodsView"])){?>checked<?php }?>/> <span>보임</span></label>
							<label><input type="checkbox" name="goodsView[]" value="notLook" <?php if($TPL_VAR["sc"]["goodsView"]&&in_array('notLook',$TPL_VAR["sc"]["goodsView"])){?>checked<?php }?>/> <span>안보임</span></label>
						</td>
						<th>과세/비과세</th>
						<td no=1 >
							<label><input type="checkbox" name="taxView[]" value="tax" <?php if($TPL_VAR["sc"]["taxView"]&&in_array('tax',$TPL_VAR["sc"]["taxView"])){?>checked<?php }?>/> <span>과세</span></label>
							<label><input type="checkbox" name="taxView[]" value="exempt" <?php if($TPL_VAR["sc"]["taxView"]&&in_array('exempt',$TPL_VAR["sc"]["taxView"])){?>checked<?php }?> row_check_all /> <span>비과세</span></label>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
<?php if($_GET["scriptPaging"]=='y'){?>
<div style="padding:10px 0px 10px 0px; text-align:center">
검색된 요청자를 → 대상자에 <span class="btn small orange"><button type="button" onclick="serchMemberInput('<?php echo $_GET["callPage"]?>');">넣기</button></span>
또는
선택된 요청자를 → 대상자에 <span class="btn small orange"><button type="button" onclick="selectMemberInput('<?php echo $_GET["callPage"]?>');">넣기</button></span>
</div>
<?php }?>
<!-- 주문리스트 검색폼 : 끝 -->
<div class="clearbox">
	<ul class="left-btns">
		<li>
			<div id="search_count" class="hide left-btns-txt">
				총 <b>0</b> 개
			</div>
		</li>
	</ul>
<?php if($_GET["scriptPaging"]!='y'){?>	
	<ul class="right-btns">
		<li><select class="custom-select-box-multi" name="orderby" onchange="document.memberForm.submit();">
			<option value="regist_date" <?php if($TPL_VAR["orderby"]=='regist_date'){?>selected<?php }?>>최근등록순</option>
			<option value="goods_name" <?php if($TPL_VAR["orderby"]=='goods_name'){?>selected<?php }?>>상품명순</option>
			<option value="page_view" <?php if($TPL_VAR["orderby"]=='page_view'){?>selected<?php }?>>페이지뷰순</option>
		</select></li>
		<li><select  class="custom-select-box-multi" name="perpage" onchange="document.memberForm.submit();">
			<option id="dp_qty10" value="10" <?php if($TPL_VAR["perpage"]== 10){?> selected<?php }?> >10개씩</option>
			<option id="dp_qty50" value="50" <?php if($TPL_VAR["perpage"]== 50){?> selected<?php }?> >50개씩</option>
			<option id="dp_qty100" value="100" <?php if($TPL_VAR["perpage"]== 100){?> selected<?php }?> >100개씩</option>
			<option id="dp_qty200" value="200" <?php if($TPL_VAR["perpage"]== 200){?> selected<?php }?> >200개씩</option>
		</select></li>
	</ul>
<?php }?>
</div>

<!-- 주문리스트 테이블 : 시작 -->
<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
<?php if($_GET["scriptPaging"]!='y'){?><col width="30" /><?php }?>
		<col width="40" />
		<col width="60" />
		<col />

		<col width="90" />
		<col width="90" />
		<col width="70" />

		<col width="80" />
		<col width="60" />

		<col width="140" />
		<col width="170" />
		<col width="140" />

	</colgroup>
	<thead class="lth">
	<tr>
<?php if($_GET["scriptPaging"]=='y'){?>
		<th><input type="checkbox" onclick="chkAll(this,'member_chk'); allMemberClick();" class="all_member_chk"/></th>
<?php }else{?>
		<th><input type="checkbox" id="chkAll" /></th>
<?php }?>
		<th>번호</th>
		<th colspan="2">상품명</th>

		<th>정가</th>
		<th>할인가</th>
		<th>재고/가용</th>

		<th>상태</th>
		<th>노출</th>

		<th>재입고알림 신청일시</th>
		<th>재입고알림 요청자</th>
		<th>재입고알림 통보일시</th>

	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="list-row" style="height:70px;">
<?php if($_GET["scriptPaging"]=='y'){?>
			<td class="ctd"><input type="checkbox" name="member_chk[]" value="<?php echo $TPL_V1["restock_notify_seq"]?>" class="member_chk" onclick="selectMemberClick(this);" /></td>
<?php }else{?>
			<td align="center">
<?php if($TPL_V1["notify_status"]=='none'){?>
				<input type="checkbox" class="chk" name="restock_notify_seq[]" value="<?php echo $TPL_V1["restock_notify_seq"]?>" />
<?php }?>
			</td>
<?php }?>
			<td align="center" class="page_no"><?php echo $TPL_V1["_no"]?></td>
			<td align="center"><a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></a></td>
			<td align="left" style="padding-left:10px;">
<?php if($TPL_V1["tax"]=='exempt'&&$TPL_V1["cancel_type"]=='1'){?>
					<div>
					<span style="color:red;" class="left" >[비과세]</span>
					<span class="order-item-cancel-type left" >[청약철회불가]</span>
					</div>
<?php }elseif($TPL_V1["tax"]=='exempt'){?>
					<div>
					<span style="color:red;" class="left" >[비과세]</span>
					</div>
<?php }elseif($TPL_V1["cancel_type"]=='1'){?>
					<div>
					<span class="order-item-cancel-type left" >[청약철회불가]</span>
					</div>
<?php }?>
<?php if($TPL_V1["goods_code"]){?>
					<div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V1["goods_code"]?>]</div>
<?php }?>
				<a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo getstrcut($TPL_V1["goods_name"], 80)?></a> 
				<div style="padding-top:5px;"><?php echo $TPL_V1["catename"]?></div>
				<div class="goods_option">
<?php if($TPL_V1["title1"]){?>
						<img src="/admin/skin/default/images/common/icon_option.gif" /><?php echo $TPL_V1["title1"]?>:
<?php }?><?php echo $TPL_V1["option1"]?>

<?php if($TPL_V1["option2"]){?><?php if($TPL_V1["title2"]){?><?php echo $TPL_V1["title2"]?>:<?php }?><?php echo $TPL_V1["option2"]?><?php }?>
<?php if($TPL_V1["option3"]){?><?php if($TPL_V1["title3"]){?><?php echo $TPL_V1["title3"]?>:<?php }?><?php echo $TPL_V1["option3"]?><?php }?>
<?php if($TPL_V1["option4"]){?><?php if($TPL_V1["title4"]){?><?php echo $TPL_V1["title4"]?>:<?php }?><?php echo $TPL_V1["option4"]?><?php }?>
<?php if($TPL_V1["option5"]){?><?php if($TPL_V1["title5"]){?><?php echo $TPL_V1["title5"]?>:<?php }?><?php echo $TPL_V1["option5"]?><?php }?>
				</div>
			</td>
			<td align="center"><?php echo get_currency_price($TPL_V1["consumer_price"])?></td>
			<td align="center"><?php echo get_currency_price($TPL_V1["price"])?></td>
			<td align="center">
<?php if($TPL_V1["stock"]< 0){?>
				<span style='color:red'><?php echo number_format($TPL_V1["stock"])?></span>
<?php }else{?>
				<?php echo number_format($TPL_V1["stock"])?>

<?php }?>
				/
<?php if($TPL_V1["rstock"]< 0){?>
				<span style='color:red'><?php echo number_format($TPL_V1["rstock"])?></span>
<?php }else{?>
				<?php echo number_format($TPL_V1["rstock"])?>

<?php }?>
			</td>
			<td align="center"><?php echo $TPL_V1["goods_status_text"]?></td>
			<td align="center"><?php echo $TPL_V1["goods_view_text"]?></td>
			<td align="center"><?php echo $TPL_V1["regist_date"]?></td>
			<td align="center" class="hand" onclick="open_crm_summary(this,'<?php echo $TPL_V1["member_seq"]?>','<?php echo $TPL_V1["order_seq"]?>','right');"> 
<?php if($TPL_V1["member_seq"]){?>
				<div>
<?php if($TPL_V1["member_type"]=='개인'){?><img src="/admin/skin/default/images/common/icon/icon_personal.gif" vspace="0" align="absmiddle" />
<?php }elseif($TPL_V1["member_type"]=='기업'){?><img src="/admin/skin/default/images/common/icon/icon_besiness.gif" vspace="0" align="absmiddle" /><?php }?>
					<span><?php echo $TPL_V1["order_user_name"]?></span>
<?php if($TPL_V1["sns_rute"]){?>
						<span>(<img src="/admin/skin/default/images/sns/sns_<?php echo substr($TPL_V1["sns_rute"], 0, 1)?>0.gif" align="absmiddle" class="btnsnsdetail">/<span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
						</span>
<?php }else{?>
						(<span style="color:#d13b00;"><?php echo $TPL_V1["userid"]?></span>/<span class="blue"><?php echo $TPL_V1["group_name"]?></span></a>)
<?php }?>
<?php if($TPL_V1["blacklist"]){?><img src="/admin/skin/default/images/common/ico_blacklist_<?php echo $TPL_V1["blacklist"]?>.png" align="absmiddle" alt="블랙리스트_<?php echo $TPL_V1["blacklist"]?>" /><?php }else{?><img src="/admin/skin/default/images/common/ico_angel.png" align="absmiddle" alt="엔젤회원" /><?php }?>
				</div>
<?php }else{?>
					<img src="/admin/skin/default/images/common/icon/icon_personal.gif" /> <span><?php echo $TPL_V1["order_user_name"]?></span> (<span class="desc">비회원</span>)
<?php if($TPL_V1["ordblacklist"]){?><img src="/admin/skin/default/images/common/ico_blacklist_<?php echo $TPL_V1["ordblacklist"]?>.png" align="absmiddle" alt="블랙리스트_<?php echo $TPL_V1["ordblacklist"]?>" /><?php }else{?><img src="/admin/skin/default/images/common/ico_angel.png" align="absmiddle" alt="엔젤회원" /><?php }?>
<?php }?>

				<?php echo $TPL_V1["cellphone"]?>

			</td>
			<td align="center"><?php if($TPL_V1["notify_status"]=='complete'){?><?php echo $TPL_V1["notify_date"]?><?php }?></td>
		</tr>
<?php }}?>
<?php }else{?>
	<tr class="list-row">
		<td align="center" colspan="12">
<?php if($TPL_VAR["search_text"]){?>
				'<?php echo $TPL_VAR["search_text"]?>' 검색된 내역이 없습니다.
<?php }else{?>
				등록된 내역이 없습니다.
<?php }?>
		</td>
	</tr>
<?php }?>
	</tbody>
	<!-- 리스트 : 끝 -->

</table>
<!-- 주문리스트 테이블 : 끝 -->
<?php if($_GET["scriptPaging"]!='y'){?>
<div class="clearbox">
	<ul class="left-btns">
		<li><span class="btn small gray"><button type="button" id="delete_btn">삭제</button></span></li>
		<!--li><span class="btn small cyanblue"><button type="button" id="sms_form">재입고알림 통보하기</button></span></li-->
	</ul>
</div>
<?php }?>

<br style="line-height:10px;" />

</form>

<!-- 페이징 -->
<div class="paging_navigation" style="margin:auto;"><?php echo $TPL_VAR["page"]["html"]?></div>

<br style="line-height:16px;" />

<div>
<iframe id="container" style="display:none;width:100%;" frameborder="0"></iframe>
</div>

<div id="export_upload" class="hide">
<form name="excelRegist" id="excelRegist" method="post" action="../goods_process/excel_upload" enctype="multipart/form-data"  target="actionFrame">

	<div class="clearbox"></div>
	<div class="item-title">상품 일괄 등록 및 수정</div>
	<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="20%" />
		<col width="80%" />
	</colgroup>
	<tr>
		<th class="its-th-align center">일괄수정</th>
		<td class="its-td">
			<input type="file" name="excel_file" id="excel_file" style="height:20px;"/>
		</td>
	</tr>
	</table>

	<div style="width:100%;text-align:center;padding-top:10px;">
	<span class="btn large cyanblue"><button id="upload_submit">확인</button></span>
	</div>

	<div style="padding:15px;"></div>

	<div style="padding-left:10px;font-size:12px;">
		* 상품을 일괄 등록하거나 수정할 때 엑셀 양식을  먼저 다운로드 받은 후에 이용하면 됩니다.(xls 양식) <br/>
		<div style="padding:3px;"></div>
		* 일괄 등록과 수정의 구분은 고유값 필드에 있는 값의 유무로 판단합니다.(고유값 필드에 값이 있으면 수정, 없으면 등록입니다.)<br/>
		<div style="padding:3px;"></div>
		* 상품 옵션은 옵션마다 1개의 행을 차지합니다.(옵션을 등록한 이후에 엑셀을 다운로드 받아서 보면 이해하기 편합니다.)<br/>
		<div style="padding:3px;"></div>
		* 옵션 항목에는 옵션값만 입력해야 하며 상품 공통 정보를 입력하면 안됩니다. 상품 공통 정보 항목도 옵션값을 입력하면 안됩니다. <br/>
	</div>

	<div style="padding:15px;"></div>


</form>
</div>

<!-- 기본검색설정 -->
<?php if($_GET["scriptPaging"]!='y'){?>
<script type="text/javascript" src="/app/javascript/js/admin-searchDefaultConfig.js"></script>
<?php }?>


<?php if($_GET["scriptPaging"]!='y'){?>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>

<?php }?>