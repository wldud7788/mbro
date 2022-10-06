<?php /* Template_ 2.2.6 2022/05/17 12:37:07 /www/music_brother_firstmall_kr/admin/skin/default/statistic_goods/goods_restock.html 000016291 */ 
$TPL_provider_1=empty($TPL_VAR["provider"])||!is_array($TPL_VAR["provider"])?0:count($TPL_VAR["provider"]);
$TPL_statlist_1=empty($TPL_VAR["statlist"])||!is_array($TPL_VAR["statlist"])?0:count($TPL_VAR["statlist"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

  
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pointLabels.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.donutRenderer.min.js"></script>    
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" />
<script type="text/javascript">
	$(document).ready(function() {
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

		$("select[name='s_category1']").live("change",function(){
			category_admin_select_load('s_category1','s_category2',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["category2"]){?>
				$("select[name='s_category2']").val('<?php echo $_GET["category2"]?>').change();
<?php }?>
			});
			category_admin_select_load('category2','category3',"");
			category_admin_select_load('category3','category4',"");
		});
		$("select[name='s_category2']").live("change",function(){
			category_admin_select_load('s_category2','s_category3',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["category3"]){?>
				$("select[name='s_category3']").val('<?php echo $_GET["category3"]?>').change();
<?php }?>
			});
			category_admin_select_load('s_category3','s_category4',"");
		});
		$("select[name='s_category3']").live("change",function(){
			category_admin_select_load('s_category3','s_category4',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["category4"]){?>
				$("select[name='s_category4']").val('<?php echo $_GET["category4"]?>').change();
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
		$("select[name='s_brands1']").live("change",function(){
			brand_admin_select_load('s_brands1','s_brands2',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["brands2"]){?>
				$("select[name='s_brands2']").val('<?php echo $_GET["brands2"]?>').change();
<?php }?>
			});
			brand_admin_select_load('s_brands2','s_brands3',"");
			brand_admin_select_load('s_brands3','s_brands4',"");
		});
		$("select[name='s_brands2']").live("change",function(){
			brand_admin_select_load('s_brands2','s_brands3',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["brands3"]){?>
				$("select[name='s_brands3']").val('<?php echo $_GET["brands3"]?>').change();
<?php }?>
			});
			brand_admin_select_load('s_brands3','s_brands4',"");
		});
		$("select[name='s_brands3']").live("change",function(){
			brand_admin_select_load('s_brands3','s_brands4',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["brands4"]){?>
				$("select[name='s_brands4']").val('<?php echo $_GET["brands4"]?>').change();
<?php }?>
			});
		});

		$("#order_by").live("change", function(){
			$("input[name='order_by']").val($(this).find("option:selected").val());
			$("form[name='sc']").submit();
		});
	});

	function set_date(start,end){
		$("input[name='sdate']").val(start);
		$("input[name='edate']").val(end);
	}
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar" class="gray-bar">
		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left"></ul>
		<!-- 타이틀 -->
		<div class="page-title"><h2>상품 통계</h2></div>
		<!-- 우측 버튼 -->
		<ul class="page-buttons-right"></ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="sub-layout-container body-height-resizing">
<?php $this->print_("goods_menu",$TPL_SCP,1);?>


	<!-- 서브메뉴 바디 : 시작-->
	<div class='slc-body-wrap'>
		<div class="slc-body">
			<div class="clearbox">
				<div class="item-title fl">상품통계 - 재입고알림</div>
				<div class="fr pd20"></div>
			</div>
			
			<div class="statistic_goods">
				<div class="search-form-container">
					<form name="sc" method="get">
					<input type="hidden" name="order_by" value="<?php echo $TPL_VAR["sc"]["order_by"]?>" />
					<table class="search-form-table" id="search_detail_table">
						<tr>
							<td>
								<table class="sf-option-table">
									<tr>
										<td>
											<input type="text" name="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker line"  maxlength="10" size="10" />
											&nbsp;<span class="gray">-</span>&nbsp;
											<input type="text" name="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker line" maxlength="10" size="10" />
											&nbsp; &nbsp;
											<span class="btn small"><input type="button" value="오늘" onclick="set_date('<?php echo date('Y-m-d')?>','<?php echo date('Y-m-d')?>')" /></span>
											<span class="btn small"><input type="button" value="3일간" onclick="set_date('<?php echo date('Y-m-d',strtotime("-3 day"))?>','<?php echo date('Y-m-d')?>')" /></span>
											<span class="btn small"><input type="button" value="일주일" onclick="set_date('<?php echo date('Y-m-d',strtotime("-7 day"))?>','<?php echo date('Y-m-d')?>')"/></span>
											<span class="btn small"><input type="button" value="1개월" onclick="set_date('<?php echo date('Y-m-d',strtotime("-1 month"))?>','<?php echo date('Y-m-d')?>')"/></span>
											<span class="btn small"><input type="button" value="3개월" onclick="set_date('<?php echo date('Y-m-d',strtotime("-3 month"))?>','<?php echo date('Y-m-d')?>')" /></span>
											<span class="btn small"><input type="button" value="전체" onclick="set_date('','')" /></span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table class="search-form-table">
						<tr>
							<td>
								<table>
									<tr>
										<td width="500">
											<table class="sf-keyword-table">
											<tr>
												<td class="sfk-td-txt"><input type="text" name="keyword" value="<?php echo $TPL_VAR["sc"]["keyword"]?>" title="상품명" /></td>
												<td class="sfk-td-btn"><button type="submit"><span>검색</span></button></td>
											</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table class="search-form-table" id="serch_tab">
						<tr id="goods_search_form" style="display:block;">
							<td>
								<table class="sf-option-table">
									<colgroup>
										<col width="80" />
										<col />
									</colgroup>
<?php if(serviceLimit('H_AD')){?>
									<tr>
										<th class="its-th">입점사</th>
										<td class="its-td">
											<div class="ui-widget">
												<select name="provider_seq_select" class="provider_seq_select" style="vertical-align:middle;">
												<option value="" selected="selected" ></option>
												<option value="1" >본사</option>
<?php if($TPL_provider_1){foreach($TPL_VAR["provider"] as $TPL_V1){?>
												<option value="<?php echo $TPL_V1["provider_seq"]?>"><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>)</option>
<?php }}?>
												</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $_GET["provider_seq"]?>" />
												<input type="text" name="provider_name" value="<?php echo $_GET["provider_name"]?>" style="width:239px" readonly />
											</div>
											<span class="ptc-charges hide"></span>
											<script>
												$( ".provider_seq_select" )
												.combobox()
												.change(function(){
													$("input[name='provider_base']").removeAttr('checked').change();
													$("input[name='provider_seq']").val($(this).val());
													$("input[name='provider_name']").val($("option:selected",this).text());
												});
											</script>
										</td>
									</tr>
<?php }?>
									<tr>
										<th>카테고리</th>
										<td>
											<select class="line" name="category1" size="1" style="width:100px;"><option value="">= 1차 분류 =</option></select>
											<select class="line" name="category2" size="1" style="width:100px;"><option value="">= 2차 분류 =</option></select>
											<select class="line" name="category3" size="1" style="width:100px;"><option value="">= 3차 분류 =</option></select>
											<select class="line" name="category4" size="1" style="width:100px;"><option value="">= 4차 분류 =</option></select>
										</td>
									</tr>
									<tr>
										<th>브랜드</th>
										<td>
											<select class="line" name="brands1" size="1" style="width:100px;"><option value="">= 1차 분류 =</option></select>
											<select class="line" name="brands2" size="1" style="width:100px;"><option value="">= 2차 분류 =</option></select>
											<select class="line" name="brands3" size="1" style="width:100px;"><option value="">= 3차 분류 =</option></select>
											<select class="line" name="brands4" size="1" style="width:100px;"><option value="">= 4차 분류 =</option></select>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					</form>
				</div>
			</div>

			<div style="width:100%; margin:auto;">
				<div class="fr">
					<div class="clearbox">
						<ul class="right-btns clearbox">
							<li>
								<select class="custom-select-box-multi" id="order_by">
									<option value="counts" <?php if($TPL_VAR["sc"]["order_by"]=='counts'){?>selected<?php }?>>재입고알림 신청수↑</option>
								</select>
							</li>
						</ul>
					</div>
				</div>
				<div id="goods_cart_list">
					<table width="100%" class="simpledata-table-style" style="margin:auto;">
						<colgroup>
							<col width="4%" />
							<col />
							<col width="10%" />
							<col width="8%" />
							<col width="7%" />
							<col width="6%" />
							<col width="6%" />
							<col width="6%" />
							<col width="7%" />
							<col width="6%" />
						</colgroup>
						<thead>
						<tr>
							<th class="top_title" colspan="3">검색 기간 내</th>
							<th class="top_title" colspan="8" bgcolor="#eeeeee">해당 상품의 현재 정보</th>
						</tr>
						<tr>
							<th>순위</th>
							<th>상품</th>
							<th>재입고알림 신청</th>
							<th>재고/가용</th>
							<th>페이지뷰</th>
							<th>장바구니</th>
							<th>위시리스트</th>
							<th>재입고알림</th>
							<th>리뷰</th>
						</tr>
						</thead>
						<tbody>
							<!-- <?php if($TPL_VAR["statlist"]){?> -->
								<!-- <?php if($TPL_statlist_1){$TPL_I1=-1;foreach($TPL_VAR["statlist"] as $TPL_V1){$TPL_I1++;?> -->
							<tr>
								<td align="center"><?php echo $TPL_I1+ 1?></td>
								<td class="ltd">
									<a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">
									<img class="small_goods_image" src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" onerror="this.src='/data/icon/error/noimage_list.gif';" width="50" align="absmiddle" />
									<span style="mragin-left:5px;"><?php echo $TPL_V1["stat_goods_name"]?></span>
									</a>
								</td>
								<td class="rtd"><?php echo number_format($TPL_V1["restock_cnt"])?>회</td>
								<td class="rtd">
								<?php echo number_format($TPL_V1["tstock"])?>/
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 25){?>
									<?php echo number_format($TPL_V1["tstock"]-$TPL_V1["tbadstock"]-$TPL_V1["treservation25"])?>

<?php }else{?>
									<?php echo number_format($TPL_V1["tstock"]-$TPL_V1["tbadstock"]-$TPL_V1["treservation15"])?>

<?php }?>
								</td>
								<td class="rtd"><?php echo number_format($TPL_V1["page_view"])?></td>
								<td class="rtd"><?php echo number_format($TPL_V1["now_cart_cnt"])?></td>
								<td class="rtd"><?php echo number_format($TPL_V1["now_wish_cnt"])?></td>
								<td class="rtd"><?php echo number_format($TPL_V1["now_restock_cnt"])?></td>
								<td class="rtd"><?php echo number_format($TPL_V1["now_review_cnt"])?></td>
							</tr>
								<!-- <?php }}?> -->
							<!-- <?php }else{?> -->
							<tr>
								<td colspan="11" align="center">검색된 통계가 없습니다.</td>
							</tr>
							<!-- <?php }?> -->
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>