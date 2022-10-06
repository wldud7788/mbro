<?php /* Template_ 2.2.6 2022/05/17 12:36:46 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/subpage_layout.html 000011200 */ 
$TPL_page_menu_1=empty($TPL_VAR["page_menu"])||!is_array($TPL_VAR["page_menu"])?0:count($TPL_VAR["page_menu"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript">
$(document).ready(function() {
	// 바로가기 selectbox
	$(".pageselect").click(function(){
		$(this).toggleClass('opened');
	});
});
</script>

<form name="subPageFrm" action="../page_manager_process/save_subpage" method="post" target="actionFrame" <?php if($_GET["cmd"]=='bigdata_criteria'){?>enctype="multipart/form-data"<?php }?>>
<input type="hidden" name="page_type" value="<?php echo $_GET["cmd"]?>" />
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2><?php echo $TPL_VAR["page_info"]["page_name"]?> 페이지</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li>
				<span class="btn large icon"><button type="button" onclick="location.href='/admin/page_manager';"><span class="arrowleft"></span>&lt&nbsp; 전체 리스트</button></span>
			</li>
			<li>
				<div id="pageselect-header">
					<div class="pageselect-container clearbox">
						<ul class="header-snb clearbox">
							<li class="item">
								<div class="pageselect">
									<span class="hsnbm-name">
										설정 바로가기
									</span>
									<span class="icon">&nbsp;&nbsp;</span>
									<ul class="hsnbm-menu">
<?php if($TPL_page_menu_1){foreach($TPL_VAR["page_menu"] as $TPL_V1){?>
<?php if($TPL_VAR["page_info"]["page_name"]==$TPL_V1["name"]){?>
										<li class="selecter"><?php echo $TPL_V1["name"]?></li>
<?php }else{?>
										<li><a href="<?php echo $TPL_V1["link"]?>" <?php if($TPL_V1["target"]){?>target="_blank"<?php }?>><?php echo $TPL_V1["name"]?></a></li>
<?php }?>
<?php }}?>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</li>
		</ul>

		<!-- 우측 버튼 -->

		<ul class="page-buttons-right">
			<li><span class="btn large black"><button type="submit">저장</button></span></li>
		</ul>


	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<?php if($_GET["cmd"]=='brand_main'||$_GET["tab"]=='goods_info'){?>
<?php $this->print_("tab_menu",$TPL_SCP,1);?>

<?php }?>

<?php if($_GET["tab"]=='goods_info'){?>
<!-- 안내문구 :: 시작 -->
<div class="fl  pd10">
<?php echo $TPL_VAR["page_desc"]?>

</div>
<!-- 안내문구 :: 끝 -->
<?php }?>

<!-- 페이지 관리 테이블 : 시작 -->
<br style="line-height:40px;">
<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="20%" />
		<col width="*" />
	</colgroup>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if(in_array('link_url',$TPL_VAR["data"]["allow"])){?>
		<tr class="list-row">
			<th class="its-th-align">주소</th>
			<td class="its-td">
				<span class="link_url"><?php echo $TPL_VAR["data"]["link_url"]?></span>
				<span class="btn small default"><button type="button" class="btn_view_link" data-type="<?php echo $_GET["cmd"]?>" data-href="<?php echo $TPL_VAR["data"]["link_url"]?>" >보기</button></span>
			</td>
		</tr>
<?php }?>

<?php if(in_array('banner',$TPL_VAR["data"]["allow"])){?>
		<tr class="list-row">
			<th class="its-th-align">배너</th>
			<td class="its-td">
<?php $this->print_("bannerlist",$TPL_SCP,1);?>

			</td>
		</tr>
<?php }?>

<?php if(in_array('search_filter',$TPL_VAR["data"]["allow"])){?>
<?php if(is_array($TPL_R1=$TPL_VAR["data"]["filter_col"])&&!empty($TPL_R1)){$TPL_S1=count($TPL_R1);$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
				<tr class="list-row">
<?php if($TPL_I1== 0){?>
					<th class="its-th-align" rowspan="<?php echo $TPL_S1?>">검색 필터</th>
<?php }?>
					<td class="its-td">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
						<span class="pdr20"><label><input type="checkbox" name="search_filter[]" value="<?php echo $TPL_K2?>" <?php if(in_array($TPL_K2,$TPL_VAR["data"]["search_filter"])){?>checked<?php }?>/> <?php echo $TPL_V2?></label></span>
<?php }}?>
					</td>
				</tr>
<?php }}?>
<?php }?>

<?php if(in_array('orderby',$TPL_VAR["data"]["allow"])){?>
		<tr class="list-row">
			<th class="its-th-align">정렬</th>
			<td class="its-td">
<?php if(is_array($TPL_VAR["data"]["order_col"])){?>
<?php if(is_array($TPL_R1=$TPL_VAR["data"]["order_col"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
					<label><input type="radio" name="orderby" value="<?php echo $TPL_K1?>" <?php if(in_array($TPL_K1,$TPL_VAR["data"]["orderby"])){?>checked<?php }?>/> <?php echo $TPL_V1?></label>
<?php }}?>
<?php }else{?>
				<?php echo $TPL_VAR["data"]["order_col"]?>

<?php }?>
			</td>
		</tr>
<?php }?>

<?php if(in_array('rank',$TPL_VAR["data"]["allow"])){?>
		<tr class="list-row">
			<th class="its-th-align">순위</th>
			<td class="its-td">
				<select name="rank">
					<option value="">== 선택 ==</option>
					<option value="30"   <?php if($TPL_VAR["data"]["rank"]=='30'){?>selected<?php }?>>30위까지</option>
					<option value="50"   <?php if($TPL_VAR["data"]["rank"]=='50'){?>selected<?php }?>>50위까지</option>
					<option value="100"  <?php if($TPL_VAR["data"]["rank"]=='100'){?>selected<?php }?>>100위까지</option>
				</select>
			</td>
		</tr>
<?php }?>

<?php if(in_array('status',$TPL_VAR["data"]["allow"])){?>
		<tr class="list-row">
			<th class="its-th-align">상태</th>
			<td class="its-td">
				<span class="pdr10"><?php echo $TPL_VAR["data"]["status"]["desc"]?></span>
<?php if(is_array($TPL_R1=$TPL_VAR["data"]["status"]["col"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
					<label><input type="checkbox" name="status[]" value="<?php echo $TPL_K1?>" <?php if(in_array($TPL_K1,$TPL_VAR["data"]["status"]["chk"])){?>checked<?php }?>/> <?php echo $TPL_V1?></label>
<?php }}?>
			</td>
		</tr>
<?php }?>

<?php if(in_array('condition',$TPL_VAR["data"]["allow"])){?>
		<tr class="list-row">
			<th class="its-th-align">추천상품 - 자동(2)</th>
			<td class="its-td pd15">
<?php $this->print_("condition",$TPL_SCP,1);?>

			</td>
		</tr>
<?php }?>

<?php if(in_array('goods_info_style',$TPL_VAR["data"]["allow"])){?>
		<tr class="list-row">
			<th class="its-th-align">
				<div class="mb10">상품정보</div>
				<span class="btn small cyanblue"><button type="button" onclick="openDialog('노출 정보','#displayGoodsInfoStyle', {'width':'800','show' : 'fade','hide' : 'fade'});">노출 조건 안내</button></span>
			</th>
			<td class="its-td pd15">
<?php $this->print_("goods_info_style",$TPL_SCP,1);?>

			</td>
		</tr>
<?php }?>
<?php if(in_array('goods_info_image',$TPL_VAR["data"]["allow"])){?>
		<tr>
			<th class="its-th-align">
				<div class="mb10">이미지 사이즈</div>
			</th>
			<td class="its-td pd15">
				<select name="goods_info_image">
<?php if(is_array($TPL_R1=config_load('goodsImageSize'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_VAR["data"]["goods_info_image"]==$TPL_K1){?>
					<option value="<?php echo $TPL_K1?>" selected><?php echo $TPL_V1["name"]?></option>
<?php }else{?>
					<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1["name"]?></option>
<?php }?>
<?php }}?>
				</select>
			</td>
		</tr>
<?php }?>

	</tbody>
	<!-- 리스트 : 끝 -->
</table>
<!-- 페이지 관리 테이블 : 끝 -->
</form>

<?php if($_GET["cmd"]=='bigdata_criteria'){?>
	<br style="height: 40px;" />
	<p class="desc mb5">※ 빅데이터 저장기간 : 최근 6개월의 데이터가 저장됩니다. 6개월 이상의 데이터 구축은 고객센터(또는 홈페이지 1:1게시판)로 별도 문의해 주십시오.</p>
	<p class="desc">※ 빅데이터 상품 추천 페이지 화면 예시 : <span class="highlight-link hand" id="btn_bigdata_screen_p">데스크탑 보기</span>, <span class="highlight-link hand" type="button" id="btn_bigdata_screen_m">모바일 보기</span></p>

	<div class="hide" id="bigdata_pc_screen"><img src="/admin/skin/default/images/design/bigdata_pc_screen.gif"></div>
	<div class="hide" id="bigdata_mobile_screen"><img src="/admin/skin/default/images/design/bigdata_mobile_screen.gif"></div>

	<script type="text/javascript">
	$(document).ready(function(){
		// 빅데이터 PC 안내 화면
		$("span#btn_bigdata_screen_p").click(function(){
			openDialog("안내) 데스크탑 화면", "bigdata_pc_screen", {"width":"1030","height":"780"});
		});
		// 빅데이터 MOBILE 안내 화면
		$("span#btn_bigdata_screen_m").click(function(){
			openDialog("안내) 모바일 화면", "bigdata_mobile_screen", {"width":"860","height":"750"});
		});

	});

	</script>
<?php }?>
<div class="hide">
	<form id="ajaxFileUploadFrm" name="ajaxFileUploadFrm" method="post" enctype="multipart/form-data" target="actionFrame" action="../page_manager_process/save_banner_image"></form>
</div>

<div id="searchLinkForm" class="hide">
	<form name="searchFrm" method="get" target="_blank" action="/goods/search">
	<div class="search-wrap">
		<input type="text" id="keyword" name="" value="" placeholder="Search" />
		<span class="btn large black"><button type="button" class="btn_golink">보기</button></span>
	</div>
	</form>
</div>

<style type="text/css">
	.search-wrap { height: 100%; display: flex; flex-direction: column; align-items: center;  }
	.search-wrap input { width: 300px; height: 25px; line-height: 25px; margin: 7px 0px 15px 0px; font-size: 12pt }
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('.btn_view_link').click(function(){
		var page_type	= $(this).attr('data-type');
		var link		= $(this).attr('data-href');

		$('#searchLinkForm form').attr('target', '_blank');
		$('#searchLinkForm form').attr('action', link);

		switch(page_type){
			case 'search_result':
				$('#keyword').prop('name', 'osearchtext');
				$('#keyword').prop('placeholder','Search');

				openDialog('검색', 'searchLinkForm', {'width': 400, 'height': 220});

				$('.btn_golink').unbind('click');
				$('.btn_golink').click(function(){	golink(page_type, link);	});

				break;

			case 'bigdata_criteria':
				$('#keyword').prop('name', 'no');
				$('#keyword').prop('placeholder','상품번호');

				openDialog('검색', 'searchLinkForm', {'width': 400, 'height': 220});
				$('.btn_golink').unbind('click');
				$('.btn_golink').click(function(){	golink(page_type, link);	});

				break;
			default:
				window.open(link, '_blank');
				break;
		}
	});
});

function golink(page_type, link){
	if($('#keyword').val() == ''){
		alert('검색어를 입력하세요!');
	}else{
		
		$('#searchLinkForm form').submit();
	}
}


</script>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>