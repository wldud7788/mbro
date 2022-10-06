<?php /* Template_ 2.2.6 2022/05/17 12:37:08 /www/music_brother_firstmall_kr/admin/skin/default/statistic_goods/goods_search.html 000007412 */ 
$TPL_statlist_1=empty($TPL_VAR["statlist"])||!is_array($TPL_VAR["statlist"])?0:count($TPL_VAR["statlist"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<!--[if IE]><script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.donutRenderer.min.js"></script>   
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" />
<script type="text/javascript">
	$(document).ready(function() {
		$("#order_by").live("change", function(){
			$("input[name='order_by']").val($(this).find("option:selected").val());
			$("form[name='sc']").submit();
		});

		$("span.btn-direct-open").bind("click",function(){
			
			var nClass		= $(this).attr('class');
			var obj = $(this).closest("tr").next().find("td").eq(0);
			var keyword = $(this).closest("td").find("span").eq(0).html();		
			var keysort = $(this).attr('keysort');
			var url = "goods_search_view?keyword="+keyword+"&keysort="+keysort;
			if( nClass.search(/opened/) == -1 ){
				$(this).addClass('opened');
				obj.html('<iframe frameborder="0" width="100%" height="300" scrolling="no"></iframe>');
				obj.find("iframe").attr("src",url);
				obj.removeClass("hide");
			}else{
				$(this).removeClass('opened');
				obj.addClass("hide");
			}
		});

		$("span.btn-administration").bind("click",function(){
			var keyword = $(this).closest("td").find("span").eq(0).html();

			var url = "goods_search_detail?keyword="+keyword;				
			$("div#dialog_goods_search_detail").html("<iframe src='"+url+"' frameborder='0' width='750' height='550'></iframe>");		
			openDialog("검색어 자세히 - "+keyword, "dialog_goods_search_detail", {"width":800,"height":600});
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
				<div class="item-title fl">상품통계 - 검색어</div>
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
											<td class="sfk-td-txt"><input type="text" name="keyword" value="<?php echo $TPL_VAR["sc"]["keyword"]?>" title="검색어" /></td>
											<td class="sfk-td-btn"><button type="submit"><span>검색</span></button></td>
										</tr>
										</table>
									</td>
								</tr>
								</table>
							</td>
						</tr>
					</table>
					</form>
				</div>
			</div>

			<div style="100%; margin:auto;">

				<div class="fr">
					<div class="clearbox">
						<ul class="right-btns clearbox">
							<li>
								<select class="custom-select-box-multi" id="order_by">
									<option value="counts" <?php if($TPL_VAR["sc"]["order_by"]=='counts'){?>selected<?php }?>>검색 횟수↑</option>
								</select>
							</li>
						</ul>
					</div>
				</div>

				<div id="goods_cart_list">
					<table width="100%" class="simpledata-table-style" style="margin:auto;">
					<colgroup>
						<col width="7%" />
						<col />
						<col width="7%" />
					</colgroup>
					<thead>
					<tr>
						<th>순위</th>
						<th>검색어</th>
						<th>검색 횟수</th>
					</tr>
					</thead>
					<tbody>
					<!-- <?php if($TPL_VAR["statlist"]){?> -->
						<!-- <?php if($TPL_statlist_1){$TPL_I1=-1;foreach($TPL_VAR["statlist"] as $TPL_V1){$TPL_I1++;?> -->						
					<tr>
						<td align="center"><?php echo $TPL_I1+ 1?></td>
						<td class="ltd pdl20">
							<span style="display:inline-block;width:90%;"><?php echo $TPL_V1["keyword"]?></span>
							<span class="btn-direct-open" keysort="<?php echo $TPL_I1+ 1?>"><span class="hide">바로열기</span></span>
							<span class="btn-administration"><span class="hide">새창</span></span>
						</td>
						<td class="rtd"><?php echo number_format($TPL_V1["keyword_cnt"])?>회</td>
					</tr>
					<tr>
						<td colspan="3" align="center" class="hide">						
						</td>
					</tr>
						<!-- <?php }}?> -->
					<!-- <?php }else{?> -->
					<tr>
						<td colspan="3" align="center">검색된 통계가 없습니다.</td>
					</tr>
					<!-- <?php }?> -->
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="dialog_goods_search_detail"></div>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>