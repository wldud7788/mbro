<?php /* Template_ 2.2.6 2021/11/16 15:18:16 /www/music_brother_firstmall_kr/admincrm/skin/default/member/member_coupon_list.html 000012197 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<?php if($_GET["tab"]!='2'){?>
<script type="text/javascript" src="/app/javascript/plugin/validate/jquery.validate.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" ></script>
<?php }?>
<script type="text/javascript">
	$(document).ready(function() {
		setDefaultText();
		$(".all-check").toggle(function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',true);
		},function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',false);
		});

		// 쿠폰사용가능한 상품 조회하기 (적용대상조회)
		$('.coupongoodsreviewbtn').live("click",function(){
			var coupon_type = $(this).attr("coupon_type");
			var use_type = $(this).attr("use_type");
			var issue_type = $(this).attr("issue_type");
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
				var download_seq = $(this).attr("download_seq");
				var coupon_seq = $(this).attr("coupon_seq");
				var coupongoodsreviewerurl = '/admin/coupon/coupongoodsreviewer?no='+download_seq+'&coupon_type='+coupon_type+'&coupon_seq='+coupon_seq+'&download_seq='+download_seq;
<?php }else{?>
				var coupon_seq = $(this).attr("coupon_seq"); 
				var coupongoodsreviewerurl = '/admin/coupon/coupongoodsreviewer?no='+coupon_seq+'&coupon_type='+coupon_type;
<?php }?>
			var coupon_name = $(this).attr("coupon_name");   
			if( use_type == 'offline' ) {
				addFormDialog(coupongoodsreviewerurl, '650', '500', '쿠폰정보','false');
			}else{
				addFormDialog(coupongoodsreviewerurl, '450', '500', '쿠폰정보','false');
			}
		});
		//상품 조회후 상품검색창
		$("input:button[name=goodssearchbtn]").live("click",function(){
			var goods_seq		= $("#coupongoods_goods_seq").val();
			var coupon_seq	= $(this).attr("coupon_seq");

			if(!goods_seq) {
				openDialogAlert("상품번호를 정확히 입력해 주세요.",'260','140',function(){$("#coupongoods_goods_seq").focus();return;});
			}else{ 
				$.ajax({
					'url' : '/admin/coupon/coupongoodssearch',
					'data' : {'coupon':coupon_seq,'goods':goods_seq},
					'type' : 'post',
					'dataType': 'json',
					'success' : function(res){ 
						$(".coupongoodsreviewerno").hide();//상품사용불가
						$(".coupongoodsrevieweryes").hide();//쿠폰사용가능
						if( res.result == 'goodsyes' ) {  
							var imgsrc = (eval("res.goods.src"))?res.goods.src:"/admin/skin/default/images/common/noimage_list.gif";
							$(".coupongoodsrevieweryes").show(); 
							$(".coupongoodsrevieweryes .issueGoods").find(".image").html('<img class="goodsThumbView" alt="" src="'+imgsrc+'" width="50" height="50">'); 
							$(".coupongoodsrevieweryes .issueGoods").find(".name").html(res.goods.name);
							$(".coupongoodsrevieweryes .issueGoods").find(".price").html(res.goods.price);
							$(".coupongoodsrevieweryes .issueGoods").attr("goods_seq",goods_seq); 
							
							openDialog('상품번호 찾기',"coupongoodsreviewerpopup",{"width":"480","height":"250"});
						}else if( res.result == 'goodsno' ) {  
							var imgsrc = (eval("res.goods.src"))?res.goods.src:"/admin/skin/default/images/common/noimage_list.gif";
							$(".coupongoodsreviewerno").show();
							$(".coupongoodsrevieweryes .issueGoods").find(".image").html('<img class="goodsThumbView" alt="" src="'+imgsrc+'" width="50" height="50">'); 
							$(".coupongoodsrevieweryes .issueGoods").find(".name").html(res.goods.name);
							$(".coupongoodsrevieweryes .issueGoods").find(".price").html(res.goods.price);
							$(".coupongoodsrevieweryes .issueGoods").attr("goods_seq",goods_seq); 
							
							openDialog('상품번호 찾기',"coupongoodsreviewerpopup",{"width":"400","height":"250"});
						}else{ 
							openDialogAlert("상품을 찾을 수 없습니다.<br/>확인 후 다시 입력하시기 바랍니다.",'250','160'); 
						}
					}
				});
			}
		});
		
		//상품상세보기
		$('.coupongoodsdetail').live("click",function(){ 
			window.open("/goods/view?no="+$(".coupongoodsrevieweryes .issueGoods").attr("goods_seq"),'','');
		});

	 
		$("[name='select_date']").click(function() {
			switch($(this).attr("id")) {
				case 'today' :
					$("input[name='sdate']").val(getDate(0));
					$("input[name='edate']").val(getDate(0));
					break;
				case '3day' :
					$("input[name='sdate']").val(getDate(3));
					$("input[name='edate']").val(getDate(0));
					break;
				case '1week' :
					$("input[name='sdate']").val(getDate(7));
					$("input[name='edate']").val(getDate(0));
					break;
				case '1month' :
					$("input[name='sdate']").val(getDate(30));
					$("input[name='edate']").val(getDate(0));
					break;
				case '3month' :
					$("input[name='sdate']").val(getDate(90));
					$("input[name='edate']").val(getDate(0));
					break;
				default :
					$("input[name='sdate']").val('');
					$("input[name='edate']").val('');
					break;
			}
		});

		$(".offline_use").click(function (){
			$("#download_seq").val($(this).attr('download_seq'));
			openDialog("<span class='desc'>쿠폰사용하기</span>", "couponuse_area", {"width":"370","height":"200"});
		});

	});

	function issue_list(coupon_seq){
		window.open('/popup/issue_list?coupon_seq='+coupon_seq+'','issue_list','width=500,height=350');
	}
</script>
<style type="text/css">
	table.mqs-menu {border-collapse:collapse; border:1px solid #c5c7ce; border-bottom:0px;}
	table.mqs-menu td {border-left:1px solid #c5c7ce; border-bottom:0px solid #c5c7ce; background-color:#f7f7f7;}
	table.mqs-menu td.selected {border:1px solid #7f8180; border-bottom:0px; background-color:#fff; border-bottom:0px;}
	table.mqs-menu td a {display:inline-block; padding:10px 0px; width:150px; text-align:center; color:#9194a1}
	table.mqs-menu td.selected a {font-weight:bold; color:#333}
	/* 검색폼 양식
	div.search-form-container {background:#e6e9e9; padding:15px 0 10px 0;}
	div.search-form-container table.search-form-table	{margin:auto;}
	div.search-form-container table.sf-option-table th	{height:22px; text-align:left; padding-right:10px;}
	div.search-form-container table.sf-keyword-table {width:510px; border:2px solid #000; border-collapse:collapse; background-color:#fff; table-layout:fixed;}
	div.search-form-container table.sf-keyword-table .sfk-td-txt {padding-right:5px;}
	div.search-form-container table.sf-keyword-table .sfk-td-txt input {width:100%; height:22px; padding:0px; border:0px; margin:0px; background-color:#fff; line-height:22px; text-align:center;}
	div.search-form-container table.sf-keyword-table .sfk-td-btn {width:31px; text-align:center;}
	div.search-form-container table.sf-keyword-table .sfk-td-btn button {width:32px; height:26px; border:0px; background:url('/admin/skin/default/images/common/btn_search.gif') no-repeat center center; cursor:pointer}
	div.search-form-container table.sf-keyword-table .sfk-td-btn button span {display:none} */
	.icon-check {padding-left:10px; background:url('/admin/skin/default/images/common/icon_check.gif') no-repeat 0 2px;}
</style>

<!-- 타이틀 -->
<div id="main-qna-summary">
	<table class="mqs-menu fl">
		<tr>
			<td <?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>class="selected"<?php }?>><a href="?tab=1">보유한 쿠폰(<?php echo $TPL_VAR["unusedcount"]?>/<?php echo $TPL_VAR["totalcount"]?>) </a></td>
			<td <?php if($_GET["tab"]=='2'){?>class="selected"<?php }?>><a href="?tab=2">다운로드 가능쿠폰(<?php echo $TPL_VAR["svcount"]?>)</a></td>
			<td <?php if($_GET["tab"]=='3'){?>class="selected"<?php }?>><a href="?tab=3">보유한 코드(<?php echo $TPL_VAR["promotionCount"]?>)</a></td>
		</tr>
	</table>
	<div class="main-summary-contents"></div>
</div>
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table_style">
		<thead>
			<tr>
				<th width="50" >번호</th>
				<th width="10%" >발급일</th>
				<th>쿠폰명 </th>
				<th width="22%">혜택</th>
				<th width="10%" >유효기간</th>
				<th width="10%" >남은 일자</th>
				<th width="10%" >사용여부</th>
				<th width="10%" >조건</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
<?php if($TPL_V1["use_type"]=='offline'&&$TPL_V1["use_status"]=='unused'){?>
				<tr class="offline_use hand" coupon_seq="<?php echo $TPL_V1["coupon_seq"]?>" download_seq="<?php echo $TPL_V1["download_seq"]?>">
<?php }else{?>
				<tr>
<?php }?> 
				<td class="cell" ><?php echo $TPL_V1["number"]?></td>
				<td class="cell" ><?php echo $TPL_V1["date"]?></td>
				<td class="cell left pdl10" nowrap="nowrap">
					<?php echo $TPL_V1["cp_name"]?><?php if($TPL_V1["sale_agent"]=='m'){?><img src="/admin/skin/default/images/common/icon_mobile.gif" ><?php }?>
				</td>
				<td class="cell left pdl10" ><?php echo $TPL_V1["salepricetitle"]?></td>
				<td class="cell" ><?php echo $TPL_V1["issuedate"]?></td>
				<td class="cell" ><?php echo $TPL_V1["issuedaylimit"]?></td>
				<td class="cell" ><?php echo $TPL_V1["use_status_title"]?><br /><?php echo $TPL_V1["goodsview"]?></td>
				<td class="cell" >
<?php if($TPL_V1["type"]=='offline_emoney'){?> 
						-
<?php }else{?>
						<span class="btn small "><input type="button" class="coupongoodsreviewbtn" coupon_type="<?php if($TPL_V1["type"]=='offline_coupon'){?>offline<?php }else{?>online<?php }?>" coupon_seq="<?php echo $TPL_V1["coupon_seq"]?>" download_seq="<?php echo $TPL_V1["download_seq"]?>"  use_type="<?php echo $TPL_V1["use_type"]?>"  issue_type="<?php echo $TPL_V1["issue_type"]?>"   coupon_name="<?php echo $TPL_V1["coupon_name"]?>" value="상세" /></span> 
<?php }?>  
				</td>
			<tr>
<?php }}?>
<?php }else{?>
			<tr>
				<td colspan="10" align="center" class="cell">
					보유한 쿠폰이 없습니다.
				</td>
			<tr>
<?php }?> 
		</tbody>
	</table>
<?php }else{?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table_style">
		<thead>
			<tr>
				<th width="50" >번호</th>
				<th width="13%">종류</th>
				<th>쿠폰명(할인)</th>
				<th width="25%" >다운로드 기간 (포인트 전환)</th>
				<th width="17%">유효기간</th>
				<th width="10%" >조건</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<tr>
				<td class="cell"><?php echo $TPL_V1["number"]?></td>
				<td class="cell"><?php echo $TPL_V1["issuebtn"]?></td>
				<td class="cell left pdl10">
					<?php echo $TPL_V1["coupon_name"]?> (<?php echo $TPL_V1["salepricetitle"]?>)
				</td>
				<td class="cell"><?php echo $TPL_V1["downdate"]?></td>
				<td class="cell"><?php echo $TPL_V1["downloaddate"]?></td> 
				<td class="cell">
<?php if($TPL_V1["type"]!='offline_emoney'){?> 
							<span class="btn small "><input type="button" class="coupongoodsreviewbtn" coupon_type="<?php if($TPL_V1["type"]=='offline_coupon'){?>offline<?php }else{?>online<?php }?>" coupon_seq="<?php echo $TPL_V1["coupon_seq"]?>" download_seq="<?php echo $TPL_V1["download_seq"]?>"  use_type="<?php echo $TPL_V1["use_type"]?>"  issue_type="<?php echo $TPL_V1["issue_type"]?>"   coupon_name="<?php echo $TPL_V1["coupon_name"]?>" value="상세" /></span> 
<?php }?>  
				</td>
			</tr>
<?php }}?>
<?php }else{?>
			<tr >
				<td colspan="6" align="center" class="cell">
					다운가능한 쿠폰이 없습니다.
				</td>
			<tr>
<?php }?>
		</tbody>
	</table>

<?php }?>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td align="center">
			<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
		</td>
	</tr>
</table>

<div id="showList" class="hide"> </div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>