<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/statistic_sales/goods_goods.html 000012124 */ 
$TPL_statlist_1=empty($TPL_VAR["statlist"])||!is_array($TPL_VAR["statlist"])?0:count($TPL_VAR["statlist"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<style type="text/css">
	/* 간단 데이터 테이블 스타일 */
	table.salesgoods-table-style {border-collapse:collapse;}
	table.salesgoods-table-style th {min-height:24px; line-height:24px; border:1px solid #c8c8c8; color:#666; font-weight:normal;}
	table.salesgoods-table-style td {padding:5px 5px; border:1px solid #d7d7d7; color:#666}
	table.salesgoods-table-style th.tdLineRight,
	table.salesgoods-table-style td.tdLineRight {border-right:1px solid #a6a6a6;}
	table.salesgoods-table-style tr.trLineBottom th,
	table.salesgoods-table-style tr.trLineBottom td {border-bottom:1px solid #a6a6a6;}
	table.salesgoods-table-style tr.trLineTop th,
	table.salesgoods-table-style tr.trLineTop td {border-top:1px solid #a6a6a6;}

	/* 상품 정보 테이블 스타일 */	
	table.simpledata-table-style .inner_tb td { border:0px; }
	table.simpledata-table-style thead td.top_title {text-align:center;}
	table.simpledata-table-style tbody td.ltd {text-align:left;padding-left:5px;background-color:#fff;}
	table.simpledata-table-style tbody td.rtd {text-align:right;padding-right:5px;background-color:#fff;}
	table.simpledata-table-style tbody td.nulltd {background-color:#e6e6e6;}
	table.simpledata-table-style tbody td.ltd.optiontd {padding-left:15px;}
	table.simpledata-table-style .r_line { border-right:1px solid #a6a6a6; }
	.linecolor { background-color:#FFFFE8 !important; }
</style>
<script>
	$(function(){
		/* 카테고리 불러오기 */
		category_admin_select_load('','category1','',function(){
<?php if($TPL_VAR["sc"]["category1"]){?>
			$("select[name='category1']").val('<?php echo $_GET["category1"]?>').change();
<?php }?>
		});
		$("select[name='category1']").bind("change",function(){
			category_admin_select_load('category1','category2',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["category2"]){?>
				$("select[name='category2']").val('<?php echo $_GET["category2"]?>').change();
<?php }?>
			});
			category_admin_select_load('category2','category3',"");
			category_admin_select_load('category3','category4',"");
		});
		$("select[name='category2']").bind("change",function(){
			category_admin_select_load('category2','category3',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["category3"]){?>
				$("select[name='category3']").val('<?php echo $_GET["category3"]?>').change();
<?php }?>
			});
			category_admin_select_load('category3','category4',"");
		});
		$("select[name='category3']").bind("change",function(){
			category_admin_select_load('category3','category4',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["category4"]){?>
				$("select[name='category4']").val('<?php echo $_GET["category4"]?>').change();
<?php }?>
			});
		});

		/* 브랜드 불러오기 */
		brand_admin_select_load('','brands1','',function(){
<?php if($TPL_VAR["sc"]["brands1"]){?>
			$("select[name='brands1']").val('<?php echo $_GET["brands1"]?>').change();
<?php }?>
		});
		$("select[name='brands1']").bind("change",function(){
			brand_admin_select_load('brands1','brands2',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["brands2"]){?>
				$("select[name='brands2']").val('<?php echo $_GET["brands2"]?>').change();
<?php }?>
			});
			brand_admin_select_load('brands2','brands3',"");
			brand_admin_select_load('brands3','brands4',"");
		});
		$("select[name='brands2']").bind("change",function(){
			brand_admin_select_load('brands2','brands3',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["brands3"]){?>
				$("select[name='brands3']").val('<?php echo $_GET["brands3"]?>').change();
<?php }?>
			});
			brand_admin_select_load('brands3','brands4',"");
		});
		$("select[name='brands3']").bind("change",function(){
			brand_admin_select_load('brands3','brands4',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["brands4"]){?>
				$("select[name='brands1']").val('<?php echo $_GET["brands1"]?>').change();
<?php }?>
			});
		});


		// 상품 옵션 불러오기 :: 2014-08-06 lwh
		$(".btn-direct-open").bind("click", function(){
			var goods_seq	= $(this).attr("goods_seq");
			var nClass		= $(this).attr('class');
			var sdate		= $("input[name='sdate']").val();
			var edate		= $("input[name='edate']").val();
			var option_name	= "";
			
			// 상품 옵션 호출
			if	(nClass.search(/opened/) == -1){
				$.ajax({
					'url'		: './sales_option_ajax',
					'data'		: {'goods_seq':goods_seq,'sdate':sdate,'edate':edate},
					'type'		: 'post',
					'dataType'	: 'json',
					'success'	: function(data) {
						var tb_html	= "<table style='margin-left:50px;' width='58%'>";
						tb_html += "<colgroup><col width='5%' /><col /><col width='10%' /><col width='13%' /><col width='13%' /></colgroup>";
						tb_html += "<tr><th>순위</th><th>옵션명</th><th>판매 수량</th><th>판매 금액</th><th>재고 / 가용</th></tr>";
						$.each(data, function(idx,item){						
							tb_html = tb_html + "<tr>"
							+ "<td style='background-color:#fff;' align='center'>" + (idx+1) + "</td>"
							+ "<td class='ltd optiontd'> <img src='/admin/skin/default/images/common/icon_option.gif' /> " + item.option1 + item.option2 + item.option3 + item.option4 + item.option5 + "</td>"
							+ "<td class='rtd'>" + item.option_cnt + "개</td>"
							+ "<td class='rtd'>" + comma(item.option_price) + "원</td>"
							+ "<td class='rtd'>" + comma(item.stock) + " / "
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 25){?>
							+ comma(item.stock - item.badstock - item.reservation25)
<?php }else{?>
							+ comma(item.stock - item.badstock - item.reservation15)
<?php }?>
							+ "</td>"
							+ "</tr>";
						});
						tb_html += "</table>";						
						
						$("#option_"+goods_seq).html(tb_html);
					}
				});

				$("#goods_area_"+goods_seq).show();
				$(this).addClass("opened");
			}else{
				$("#goods_area_"+goods_seq).hide();
				$(this).removeClass("opened");
			}
		});
	});

	function excel_download(){
		$(".goods_link_url").each(function(){
			var type = $(this).attr('linkType');
			if(type == 'src')	$(this).hide();
			if($(this).attr(type).indexOf('http')){
				$(this).attr(type, gl_protocol + document.domain + $(this).attr(type));
				$(this).attr("onerror","this.src='/admin/skin/default/statistic_sales/" + gl_protocol + document.domain +"/data/icon/error/noimage_list.gif';");
			}
		});
		divExcelDownload('상품별통계','#goods_cart_list');
		$(".goods_link_url").show();
	}
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">

		</ul>

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>판매 상품 통계</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">

		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->

<div id="search_container">
	<form class='search_form' >	
<?php $this->print_("goods_search",$TPL_SCP,1);?>


	<!-- 서브메뉴 바디 : 시작-->
	<div class="contents_dvs v2">
		<div class="title_dvs">
			<div class="item-title">통계 상세</div>
			<div class="resp_btn_dvs">			
				<button type="button" class="resp_btn v3" onclick="excel_download()" > <img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /><span>다운로드</span></button>
				<select name="order_by" onchange="$(this.form).submit();">
					<option value="cnt" <?php if($TPL_VAR["sc"]["order_by"]=='cnt'){?>selected<?php }?>>판매수량↑</option>
					<option value="price" <?php if($TPL_VAR["sc"]["order_by"]=='price'){?>selected<?php }?>>판매금액↑</option>
				</select>			
			</div>
		</div>
		
		<div id="goods_cart_list">
			<table class="table_row_basic">
				<colgroup>
					<col width="6%" />
					<col />
					<col width="7%" />
					<col width="7%" />
					<col width="7%" />
					<col width="8%" />
					<col width="7%" />
					<col width="6%" />
					<col width="8%" />
					<col width="8%" />			
					<col width="6%" />
				</colgroup>
				<thead>				
				<tr>
					<th>순위</th>
					<th>상품</th>
					<th>옵션</th>
					<th>판매 수량</th>
					<th class="r_line">판매 금액</th>

					<th>재고</th>
					<th>페이지뷰</th>
					<th>장바구니</th>
					<th>위시리스트</th>
					<th>재입고알림</th>
					<th>리뷰</th>
				</tr>
				</thead>
				<tbody>
				<!-- <?php if($TPL_VAR["statlist"]){?> -->
					<!-- <?php if($TPL_statlist_1){foreach($TPL_VAR["statlist"] as $TPL_V1){?> -->
						<!-- <?php if($TPL_V1["goods_first"]){?> -->
				<tr>
					<td align="center" <?php if($TPL_V1["line_col"]){?>class="linecolor"<?php }?>><?php echo $TPL_V1["lank"]?></td>
					<td class="ltd <?php if($TPL_V1["line_col"]){?>linecolor<?php }?>">
						<table width="100%" class="inner_tb">
						<tr>
							<td width="50px">
								<img class="goods_link_url small_goods_image" linkType="src" src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" onerror="this.src='/data/icon/error/noimage_list.gif';" width="50" align="absmiddle" />
							</td>
							<td style="padding-left:5px;">
<?php if(serviceLimit('H_AD')){?> 
								<div class="desc">[<?php echo $TPL_V1["provider_name"]?>]</div>
<?php }?>
								<a class="goods_link_url" linkType="href" href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo $TPL_V1["stat_goods_name"]?></a>
							</td>
						</tr>
						</table>
					</td>
					<td width="70" class="desc ltd <?php if($TPL_V1["line_col"]){?>linecolor<?php }?>">
<?php if($TPL_V1["title1"]){?><?php echo $TPL_V1["title1"]?> : <?php echo $TPL_V1["option1"]?><br /><?php }?>
<?php if($TPL_V1["title2"]){?><?php echo $TPL_V1["title2"]?> : <?php echo $TPL_V1["option2"]?><br /><?php }?>
<?php if($TPL_V1["title3"]){?><?php echo $TPL_V1["title3"]?> : <?php echo $TPL_V1["option3"]?><br /><?php }?>
<?php if($TPL_V1["title4"]){?><?php echo $TPL_V1["title4"]?> : <?php echo $TPL_V1["option4"]?><br /><?php }?>
<?php if($TPL_V1["title5"]){?><?php echo $TPL_V1["title5"]?> : <?php echo $TPL_V1["option5"]?><?php }?>
					</td>
					<td class="rtd <?php if($TPL_V1["line_col"]){?>linecolor<?php }?>"><?php echo number_format($TPL_V1["goods_cnt"])?>개</td>
					<td class="rtd r_line <?php if($TPL_V1["line_col"]){?>linecolor<?php }?>"><?php echo number_format($TPL_V1["goods_price"])?>원</td>
					
					<td class="rtd <?php if($TPL_V1["line_col"]){?>linecolor<?php }?>"><?php echo number_format($TPL_V1["tot_stock"])?></td>
					<td class="rtd <?php if($TPL_V1["line_col"]){?>linecolor<?php }?>"><?php echo number_format($TPL_V1["page_view"])?></td>
					<td class="rtd <?php if($TPL_V1["line_col"]){?>linecolor<?php }?>"><?php echo number_format($TPL_V1["now_cart_cnt"])?></td>
					<td class="rtd <?php if($TPL_V1["line_col"]){?>linecolor<?php }?>"><?php echo number_format($TPL_V1["now_wish_cnt"])?></td>
					<td class="rtd <?php if($TPL_V1["line_col"]){?>linecolor<?php }?>"><?php echo number_format($TPL_V1["now_restock_cnt"])?></td>
					<td class="rtd <?php if($TPL_V1["line_col"]){?>linecolor<?php }?>"><?php echo number_format($TPL_V1["now_review_cnt"])?></td>
				</tr>
						<!-- <?php }?> -->
				<tr class="hide" id="goods_area_<?php echo $TPL_V1["goods_seq"]?>">
					<td class="nulltd" colspan="12" id="option_<?php echo $TPL_V1["goods_seq"]?>"></td>
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
	</form>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>