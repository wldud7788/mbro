<?php /* Template_ 2.2.6 2022/02/03 12:03:17 /www/music_brother_firstmall_kr/admin/skin/default/goods/hscode_setting.html 000008171 */ 
$TPL_arr_search_keyword_1=empty($TPL_VAR["arr_search_keyword"])||!is_array($TPL_VAR["arr_search_keyword"])?0:count($TPL_VAR["arr_search_keyword"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript">
	var keyword					= "<?php echo $TPL_VAR["sc"]["keyword"]?>";
	var search_type				= "<?php echo $TPL_VAR["sc"]["search_type"]?>";
</script>
<script type="text/javascript" src="/app/javascript/js/admin-searchForm.js"></script>
<style>
	table.helpicon_table{padding:0px;margin:0px;border-top:1px solid #ddd;}
	table.helpicon_table th,table.helpicon_table td {font-weight:normal;padding:3px;margin:0px;border-right:1px solid #ddd;border-bottom:1px solid #ddd;text-align:center;}
	table.helpicon_table th:first-child,table.helpicon_table td:first-child {border-left:1px solid #ddd;}
</style>
<script type="text/javascript">
	$(document).ready(function() {

		$("#chkAll").click(function(){
			if($(this).attr("checked")){
				$(".chk").attr("checked",true).change();
			}else{
				$(".chk").attr("checked",false).change();
			}
		});

		$(".hscode_register").bind("click",function(){

			var mode			= $(this).attr("mode");
			var hscode_common	= $(this).attr("hscode_common");
			var url				= "../goods/hscode_setting_regist?dummy=";
			var querystring		= '<?php echo $_SERVER['QUERY_STRING']?>';
			if	(querystring)	url	= url + '&' + querystring;

			if(mode == "delete"){

				$(this).closest("tr").find("input[name='hscode_common[]']").prop("checked","checked");
				openDialogConfirm("HS CODE를 삭제 시키겠습니까? ",400,140,function(){
					$("#hscodeListFrm").attr("action","../goods_process/hscode_delete");
					$("#hscodeListFrm").submit();
				},function(){ return; });

			}else{

				if(mode == "modify") url = url + "&hscode_common="+hscode_common;

				$.get(url,function(data){
					$("#hscode_register_popup").html(data);
					openDialog("수출입상품코드 (HS CODE)", "hscode_register_popup", {"width":"800","height":"550","show" : "fade","hide" : "fade"});
					
					var pop_height = eval($("#hscode_register_popup").height());
					if(pop_height < 290){
						h = 200 + ($("input[name='hscode_nation[]']").length * 40)
						$("#hscode_register_popup").height(h);
					}

				});
			}

		});
		
		$("#delete_btn").click(function(){
<?php if(!$TPL_VAR["auth"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>

			var cnt = $("input:checkbox[name='hscode_common[]']:checked").length;
			if(cnt<1){
				openDialogAlert("삭제할 HS CODE를 선택해 주세요.",400,140);
				return;
			}else{
				openDialogConfirm("선택한 HS CODE를 삭제 시키겠습니까? ",400,140,function(){
					$("#hscodeListFrm").attr("action","../goods_process/hscode_delete");
					$("#hscodeListFrm").submit();
				},function(){ return; });

			}
		});

<?php if($TPL_VAR["hscode"]){?>
		$("input.chk[value='<?php echo $TPL_VAR["hscode"]?>']").closest('tr').find("button[mode='modify']").click();
<?php }?>
	});		
</script>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/searchform.css" />

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2><span class="bold fx16">HS CODE</span></h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><span class="btn large"><button type="button" onclick="document.location.href='/admin/goods/catalog';"><span class="arrowleft"></span>상품리스트</button></span></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><span class="btn large black"><button type="button" onclick="document.location.href='/admin/goods/batch_modify?mode=hscode';">상품연결</button></span></li>
			<li><span class="btn large cyanblue"><button type="button" class="hscode_register" mode="regist">HS CODE 등록</button></span></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 검색폼 : 시작 -->
<div class="search-form-container-new">
	<form name="search-form" method="get">
	<p class="mt25"></p>
	<table class="search-form-table">
		<tr>
			<td width="810">
				<table class="sf-keyword-table">
					<tr>
						<td class="sfk-td-txt">
							<div class="relative">
								<input type="text" name="keyword" id="search_keyword" value="<?php echo $TPL_VAR["sc"]["keyword"]?>" title="<?php echo implode(',',$TPL_VAR["arr_search_keyword"])?>" />
								<!-- 검색어 입력시 레이어 박스 : start -->
								<div class="search_type_text hide"><?php echo $TPL_VAR["sc"]["keyword"]?></div>
								<div class="searchLayer hide">
									<input type="hidden" name="search_type" id="search_type" value="" />
									<ul class="searchUl">
										<li><a class="link_keyword" s_type="all" href="#"><span class="txt_keyword"></span> <span class="txt_title">-전체검색</span></a></li>
<?php if($TPL_arr_search_keyword_1){foreach($TPL_VAR["arr_search_keyword"] as $TPL_K1=>$TPL_V1){?>
										<li><a class="link_keyword" s_type="<?php echo $TPL_K1?>" href="#"><?php echo $TPL_V1?>: <span class="txt_keyword"></span> <span class="txt_title">-<?php echo $TPL_V1?>로 찾기</span></a></li>
<?php }}?>
									</ul>
								</div>
								<!-- 검색어 입력시 레이어 박스 : end -->
							</div>
						</td>
						<td class="sfk-td-btn"><button type="submit"><span>검색</span></button></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	</form>
</div>
<!-- 검색폼 : 끝 -->

<form name="hscodeListFrm" id="hscodeListFrm" method="post" target="actionFrame">
<input type="hidden" name="get_hscode" value="<?php echo $TPL_VAR["hscode"]?>" />
<input type="hidden" name="keyword" value="<?php echo $TPL_VAR["keyword"]?>" />
<input type="hidden" name="search_type" value="<?php echo $TPL_VAR["search_type"]?>" />
<div class="clearbox">
	<ul class="left-btns">
		<li><span class="btn small gray"><button type="button" id="delete_btn">선택삭제</button></span></li>
	</ul>
</div>

<!-- HS CODE 리스트 시작 -->
<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="7%" />
		<col width="33%"/>
		<col width="20%" />
		<col width="20%" />
		<col width="15%"/>
	</colgroup>
	<thead>
		<tr>
			<th class="its-th-align center"><input type="checkbox" id="chkAll" /></th>
			<th class="its-th-align center">품명</th>
			<th class="its-th-align center">HS분류</th>
			<th class="its-th-align center">연결된 상품</th>
			<th class="its-th-align center">관리</th>
		</tr>
	</thead>
	<tbody>
<?php if(count($TPL_VAR["loop"])> 0){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td class="its-td-align center"><input type="checkbox" class="chk" name="hscode_common[]" value="<?php echo $TPL_V1["hscode_common"]?>" /></td>
			<td class="its-td-align center"><?php echo $TPL_V1["hscode_name"]?></td>
			<td class="its-td-align center"><?php echo $TPL_V1["hscode_common"]?></td>
			<td class="its-td-align center"><?php echo $TPL_V1["goods_cnt"]?>개</td>
			<td class="its-td-align center">
				<span class="btn small gray"><button type="button" class="hscode_register" mode="modify" hscode_common="<?php echo $TPL_V1["hscode_common"]?>">수정</button></span>
				<span class="btn small gray"><button type="button" class="hscode_register" mode="delete" hscode_common="<?php echo $TPL_V1["hscode_common"]?>">삭제</button></span>
			</td>
		</tr>
<?php }}?>
<?php }else{?>
		<tr>
			<td class="its-td-align center" colspan="5">검색된 HSCODE 가 없습니다.</td>
		</tr>
<?php }?>
	</tbody>
</table>
</form>
<!-- HS CODE 리스트 끝 -->

<!-- HS CODE 등록/수정 레이어 -->
<div id="hscode_register_popup" class="hide"></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>