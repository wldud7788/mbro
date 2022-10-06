<?php /* Template_ 2.2.6 2022/05/17 12:31:52 /www/music_brother_firstmall_kr/admin/skin/default/goods/select_auto.html 000019180 */ ?>
<style type="text/css">
	#goodsSelectorAuto tr{cursor:move}
	#goodsSelectorAuto .condition_img{text-align:right !important:border-right:none !important;}
	#goodsSelectorAuto .border_none{border-left:none !important}
	#goodsSelectorAuto .condition_txt{width:580px;color:#c0c0c0;float:left}
	#goodsSelectorAuto .condition_detail{display:none;}
</style>
<script type="text/javascript">
limit_condition = <?php if(serviceLimit('H_FR')){?>1<?php }else{?>3<?php }?>;
displayKind = '<?php echo $TPL_VAR["displayKind"]?>';

$(function(){
	select_auto_init();
	$('#goodsSelectorAuto .chg_condition').click(set_condition_goods_auto);

	$("#goodsSelectorAuto input[name='condition[]']").click(function(){
		if($(this).is(':checked')){
<?php if(serviceLimit('H_FR')){?>
			if((displayKind != 'bigdata' && $(this).val() != 'admin') || (displayKind == 'bigdata' && $(this).val() != 'order')){
				openDialog("업그레이드 안내", "nostorfreeServiceBigdataPopup", {"width":"80%","show" : "fade","hide" : "fade"});
				return;
			}
<?php }?>
			if(displayKind != 'bigdata_catalog'){
				cnt = $("#goodsSelectorAuto input[name=condition[]]:checkbox:checked").length;
				if(cnt > limit_condition){
					event.cancelBubble = false;
					if(limit_condition == 1){
						openDialog("업그레이드 안내", "nostorfreeServiceBigdataPopup", {"width":"80%","show" : "fade","hide" : "fade"});
						return;
					}
					openDialogAlert('최대 '+limit_condition+'개까지 선택할 수 있습니다.','400','160',function(){});
					return;
				}
			}

			$(this).closest('.condition_txt').css({'color':'#000000'});
			$(this).closest('.condition_txt').find('.kind_title').css({'color':'#0655f9'});
			$(this).closest('.condition_txt').find('.act_title').css({'color':'#ff0000'});
			$(this).closest('.condition_txt').find('.admin_title').css({'color':'#339900'});
		}else{
			$(this).closest('.condition_txt').css({'color':'#c0c0c0'});
			$(this).closest('.condition_txt').find('.kind_title').css({'color':'#c0c0c0'});
			$(this).closest('.condition_txt').find('.act_title').css({'color':'#c0c0c0'});
			$(this).closest('.condition_txt').find('.admin_title').css({'color':'#c0c0c0'});
		}
	});

	rank_reset();

	setAutoConditionDescription(displayKind);

	$('#goodsSelectorAuto table tbody').sortable({stop : rank_reset});
});

function select_auto_init(){
	temp = '<?php echo $TPL_VAR["criteria"]?>';
	if	(!temp) return;
	
	if(temp.indexOf('∀') > -1){
		temp_arr = temp.split('Φ');
		len = temp_arr.length;
		$.each(temp_arr.reverse(),function(k,v){
			div = v.split('∀');
			if	(div[0] == 'admin' && displayKind == 'bigdata') return;
			tr = $("input[name='condition[]'][value='"+div[0]+"']").closest('tr');
			tr.find("input[name='condition[]']").attr('checked',true);
			tr.find('.condition_txt').css({'color':'#000000'});
			tr.find('.condition_txt').find('.kind_title').css({'color':'#0655f9'});
			tr.find('.condition_txt').find('.act_title').css({'color':'#ff0000'});
			tr.find('.condition_txt').find('.admin_title').css({'color':'#339900'});
			tr.find($("input[name='auto_condition[]']")).val(div[1]);
			$('#goodsSelectorAuto .info-table-style tbody').prepend('<tr>'+tr.html()+'</tr>');
			tr.remove();
		});
	}
}

function rank_reset(){
	i = 0;
	$('#goodsSelectorAuto .rank').each(function(){$(this).text(++i)});
}

function set_condition_goods_auto(){
	condition_idx = $(this).closest('tr').index();
	condition = $("input[name='auto_condition[]']").eq(condition_idx).val();
	kind = $("input[name='condition[]']").eq(condition_idx).val();
	provider_seq = '<?php echo $_GET["provider_seq"]?>';
	$.ajax({
		type: "get",
		url: "../goods/select_auto_condition",
		data: "condition_idx="+condition_idx+"&condition="+encodeURIComponent(condition)+"&kind="+kind+"&displayKind="+displayKind+"&provider_seq="+provider_seq,
		success: function(result){
			$("div#condition_change_option_data").html(result);
			openDialog('조건 변경', 'condition_change_option', {"width":"99%","show" : "fade","hide" : "fade"});
		}
	});
}

function auto_condition_set(){
	cnt = $("#goodsSelectorAuto input[name=condition[]]:checkbox:checked").length;
	if(cnt > limit_condition && displayKind != 'bigdata_catalog'){
		if(limit_condition == 1){
			openDialog("업그레이드 안내", "nostorfreeServiceBigdataPopup", {"width":"80%","show" : "fade","hide" : "fade"});
		}
		openDialogAlert('최대 '+limit_condition+'개까지 선택할 수 있습니다.','400','160',function(){});
		return;
	}else{
		var flag = false;
		var tabIdx = $("#<?php echo $_GET["inputGoods"]?>").closest('.displayTabGoodsContainer').attr('tabIdx');
		condition = new Array();
		$("#goodsSelectorAuto input[name=condition[]]:checkbox:checked").each(function(){
			temp = $(this).closest('tr').find("input[name='auto_condition[]']").val();
			if	(temp == 'isFirst=1'){
				openDialogAlert('상세조건을 선택해주세요.','400','160',function(){});
				flag = true;
				return;
			}
			temp = $(this).val()+'∀'+temp;
			condition.push(temp);
		});

		if	(!flag){
			if	(condition.length > 0)
				$("#<?php echo $_GET["inputGoods"]?>").val(condition.join('Φ'));
			else
				$("#<?php echo $_GET["inputGoods"]?>").val('');

<?php if($_GET["displayKind"]!='relation_seller'){?>
				$("#<?php echo $_GET["auto_condition_use_id"]?>").val(1);
<?php }?>

<?php if($_GET["displayKind"]!='bigdata'&&$_GET["displayKind"]!='bigdata_catalog'){?>
<?php if($_GET["displayKind"]=='relation'){?>
				$("input[name='relation_type'][value='AUTO']").attr("checked",true).change();
<?php }else{?>
				$("select.contents_type").eq(tabIdx).val("auto").change();
<?php }?>
				setCriteriaDescription_upgrade();
<?php }else{?>
<?php if($_GET["displayKind"]=='bigdata_catalog'){?>
				setCriteriaDescription_bigdata('catalog');
<?php }else{?>
				setCriteriaDescription_bigdata();
<?php }?>
<?php }?>
			closeDialog("displayGoodsSelectPopup");
		}
	}
}

// 안내기준 팝업창
function page_criteria_pop(){
	openDialog("안내) 상품 기준", "#page_criteria_info", {'width':'600','height':'420','show' : 'fade','hide' : 'fade'});
}
</script>

<?php if($TPL_VAR["config_system"]["operation_type"]!='light'&&($TPL_VAR["displayKind"]=='bigdata'||$TPL_VAR["displayKind"]=='bigdata_catalog')){?>
<div class="fr pdb5 pdr5">
	<span class="btn small orange"><button type="button" onclick="page_criteria_pop();">안내) 상품 기준</button></span>
</div>
<?php }?>
<div id="goodsSelectorAuto">
	<div>
	<table class="info-table-style" width="100%" border="0" cellpadding="0" cellspacing="0">
		<col width="100"/>
		<col width="60"/>
		<col />
		<col width="100"/>
		<thead>
		<tr>
			<th class="its-th-align">노출 순위</th>
			<th class="its-th-align">순위 조정</th>
			<th class="its-th-align">노출 조건</th>
			<th class="its-th-align">설정</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td class="its-td-align"><span class="rank">1</span>순위</td>
			<td class="its-td-align center"><img src="/admin/skin/default/images/common/icon_move.gif"></td>
			<td class="its-td">
				<ul class="condition_txt">
					<li>
						<label>
							<input type="checkbox" name="condition[]" value="view"/>
<?php if($TPL_VAR["displayKind"]!='bigdata'&&$TPL_VAR["displayKind"]!='bigdata_catalog'){?>
							<span class="kind_title">○○○고객이 최근 본</span> 상품 기준
<?php }else{?>
							<span class="kind_title">해당 상품을</span> <span class="act_title">본</span> 다른 고객 기준
<?php }?>
						</label>
					</li>
					<li class="condition_detail">
						<span class="condition_desc"></span>
					</li>
				</ul>
			</td>
			<td class="its-td-align center">
				<span class="btn medium cyanblue">
					<button type="button" class="chg_condition" >설정</button>
				</span>
				<input type="hidden" name="auto_condition[]" value="isFirst=1"/>
			</td>
		</tr>
		<tr>
			<td class="its-td-align"><span class="rank">2</span>순위</td>
			<td class="its-td-align center"><img src="/admin/skin/default/images/common/icon_move.gif"></td>
			<td class="its-td">
				<ul class="condition_txt">
					<li>
						<label>
							<input type="checkbox" name="condition[]" value="cart"/>
<?php if($TPL_VAR["displayKind"]!='bigdata'&&$TPL_VAR["displayKind"]!='bigdata_catalog'){?>
							<span class="kind_title">○○○고객이 최근 장바구니에 담은</span> 상품 기준
<?php }else{?>
							<span class="kind_title">해당 상품을</span> <span class="act_title">장바구니에 담은</span> 다른 고객 기준
<?php }?>
						</label>
					</li>
					<li class="condition_detail">
						<span class="condition_desc"></span>
					</li>
				</ul>
			</td>
			<td class="its-td-align center">
				<span class="btn medium cyanblue">
					<button type="button" class="chg_condition" >설정</button>
				</span>
				<input type="hidden" name="auto_condition[]" value="isFirst=1"/>
			</td>
		</tr>
		<tr>
			<td class="its-td-align"><span class="rank">3</span>순위</td>
			<td class="its-td-align center"><img src="/admin/skin/default/images/common/icon_move.gif"></td>
			<td class="its-td">
				<ul class="condition_txt">
					<li>
						<label>
							<input type="checkbox" name="condition[]" value="wish"/>
<?php if($TPL_VAR["displayKind"]!='bigdata'&&$TPL_VAR["displayKind"]!='bigdata_catalog'){?>
							<span class="kind_title">○○○고객이 최근 위시리스트에 찜한</span> 상품 기준
<?php }else{?>
							<span class="kind_title">해당 상품을</span> <span class="act_title">위시리스트에 찜한</span> 다른 고객 기준
<?php }?>
						</label>
					</li>
					<li class="condition_detail">
						<span class="condition_desc"></span>
					</li>
				</ul>
			</td>
			<td class="its-td-align center">
				<span class="btn medium cyanblue">
					<button type="button" class="chg_condition" >설정</button>
				</span>
				<input type="hidden" name="auto_condition[]" value="isFirst=1"/>
			</td>
		</tr>
<?php if($TPL_VAR["displayKind"]!='bigdata'&&$TPL_VAR["displayKind"]!='bigdata_catalog'){?>
		<tr>
			<td class="its-td-align"><span class="rank">4</span>순위</td>
			<td class="its-td-align center"><img src="/admin/skin/default/images/common/icon_move.gif"></td>
			<td class="its-td">
				<ul class="condition_txt">
					<li>
						<label>
							<input type="checkbox" name="condition[]" value="restock"/>
							<span class="kind_title">○○○고객이 최근 ‘재입고알림요청’한</span> 상품 기준
						</label>
					</li>
					<li class="condition_detail">
						<span class="condition_desc"></span>
					</li>
				</ul>
			</td>
			<td class="its-td-align center">
				<span class="btn medium cyanblue">
					<button type="button" class="chg_condition" >설정</button>
				</span>
				<input type="hidden" name="auto_condition[]" value="isFirst=1"/>
			</td>
		</tr>
		<tr>
			<td class="its-td-align"><span class="rank">5</span>순위</td>
			<td class="its-td-align center"><img src="/admin/skin/default/images/common/icon_move.gif"></td>
			<td class="its-td">
				<ul class="condition_txt">
					<li>
						<label>
							<input type="checkbox" name="condition[]" value="search"/>
							<span class="kind_title">○○○고객이 최근 검색한 결과 중 최상위</span> 상품 기준
						</label>
					</li>
					<li class="condition_detail">
						<span class="condition_desc"></span>
					</li>
				</ul>
			</td>
			<td class="its-td-align center">
				<span class="btn medium cyanblue">
					<button type="button" class="chg_condition" >설정</button>
				</span>
				<input type="hidden" name="auto_condition[]" value="isFirst=1"/>
			</td>
		</tr>
<?php }?>
		<tr>
			<td class="its-td-align"><span class="rank">6</span>순위</td>
			<td class="its-td-align center"><img src="/admin/skin/default/images/common/icon_move.gif"></td>
			<td class="its-td">
				<ul class="condition_txt">
					<li>
						<label>
							<input type="checkbox" name="condition[]" value="order"/>
<?php if($TPL_VAR["displayKind"]!='bigdata'&&$TPL_VAR["displayKind"]!='bigdata_catalog'){?>
							<span class="kind_title">○○○고객이 최근 구매한</span> 상품 기준
<?php }else{?>
							<span class="kind_title">해당 상품을</span> <span class="act_title">구매한</span> 다른 고객 기준
<?php }?>
						</label>
					</li>
					<li class="condition_detail">
						<span class="condition_desc"></span>
					</li>
				</ul>
			</td>
			<td class="its-td-align center">
				<span class="btn medium cyanblue">
					<button type="button" class="chg_condition" >설정</button>
				</span>
				<input type="hidden" name="auto_condition[]" value="isFirst=1"/>
			</td>
		</tr>
<?php if($TPL_VAR["displayKind"]=='bigdata'||$TPL_VAR["displayKind"]=='bigdata_catalog'){?>
		<tr>
			<td class="its-td-align"><span class="rank">7</span>순위</td>
			<td class="its-td-align center"><img src="/admin/skin/default/images/common/icon_move.gif"></td>
			<td class="its-td">
				<ul class="condition_txt">
					<li>
						<label>
							<input type="checkbox" name="condition[]" value="review"/>
							<span class="kind_title">해당 상품을</span> <span class="act_title">상품후기 작성한</span> 다른 고객 기준
						</label>
					</li>
					<li class="condition_detail">
						<span class="condition_desc"></span>
					</li>
				</ul>
			</td>
			<td class="its-td-align center">
				<span class="btn medium cyanblue">
					<button type="button" class="chg_condition" >설정</button>
				</span>
				<input type="hidden" name="auto_condition[]" value="isFirst=1"/>
			</td>
		</tr>
<?php }?>
<?php if($TPL_VAR["displayKind"]!='bigdata'&&$TPL_VAR["displayKind"]!='bigdata_catalog'){?>
		<tr>
			<td class="its-td-align"><span class="rank">7</span>순위</td>
			<td class="its-td-align center"><img src="/admin/skin/default/images/common/icon_move.gif"></td>
			<td class="its-td">
				<ul class="condition_txt">
					<li>
						<label>
							<input type="checkbox" name="condition[]" value="admin"/>
							<span class="admin_title">관리자가 지정한</span> 기준
						</label>
					</li>
					<li class="condition_detail">
						<span class="condition_desc"></span>
					</li>
				</ul>
			</td>
			<td class="its-td-align center">
				<span class="btn medium cyanblue">
					<button type="button" class="chg_condition">설정</button>
				</span>
				<input type="hidden" name="auto_condition[]" value="isFirst=1"/>
			</td>
		</tr>
<?php }?>
		</tbody>
	</table>
	</div>
	<div class="pdt30 center">
		<span class="btn medium black">
			<input type="button" value="확인" onclick="auto_condition_set();" />
		</span>
	</div>
</div>
<div id="condition_change_option">
	<div id="condition_change_option_data"></div>
</div>

<?php if($TPL_VAR["displayKind"]=='bigdata'||$TPL_VAR["displayKind"]=='bigdata_catalog'){?>
<div id="page_criteria_info" class="hide mb10 fm_default_font">
	<p class="mb10">페이지별 상품 기준은 아래와 같습니다. 기준 상품이 없을 경우 해당 영역은 보이지 않습니다.</p>
	<table class="info-table-style" width="100%" border="0" cellpadding="0" cellspacing="0">
	<thead>
	<tr>
		<th class="its-th-align">페이지</th>
		<th class="its-th-align">기준 상품</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td class="its-td-align center">검색결과 페이지</td>
		<td class="its-td-align left">검색결과 최상위 상품</td>
	</tr>
	<tr>
		<td class="its-td-align center">카테고리 페이지</td>
		<td class="its-td-align left">카테고리 페이지 최상위 상품</td>
	</tr>
	<tr>
		<td class="its-td-align center">브랜드 페이지</td>
		<td class="its-td-align left">브랜드 페이지 최상위 상품</td>
	</tr>
	<tr>
		<td class="its-td-align center">지역 페이지</td>
		<td class="its-td-align left">지역 페이지 최상위 상품</td>
	</tr>
	<tr>
		<td class="its-td-align center">상품상세 페이지</td>
		<td class="its-td-align left">상품상세 페이지 상품</td>
	</tr>
	<tr>
		<td class="its-td-align center">장바구니 페이지</td>
		<td class="its-td-align left">장바구니에 담긴 최상위 상품</td>
	</tr>
	<tr>
		<td class="its-td-align center">위시리스트 페이지</td>
		<td class="its-td-align left">위시리스트에 담긴 최상위 상품</td>
	</tr>
	<tr>
		<td class="its-td-align center">주문완료 페이지</td>
		<td class="its-td-align left">주문 완료된 최상위 상품</td>
	</tr>
	</tbody>
	</table>
</div>
<?php }?>


<div id="nostorfreeServiceBigdataPopup" class="hide">
	<p>사용중이신 서비스에서는 해당기능이 지원되지 않습니다.</p>
	<p>상위 버전으로 업그레이드 하시길 바랍니다.</p>
	<br /><p class="center"> &lt;빅데이터 큐레이션 기능 이용 안내&gt; </p><br />
	<table class="info-table-style" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td class="its-th-align center">구분</td>
			<td class="its-th-align center">서비스 상품</td>
			<td class="its-th-align center">빅데이터 큐레이션</td>
			<td class="its-th-align center">비고</td>
		</tr>
		<tr>
			<td class="its-td-align center" rowspan="2">오픈마켓</td>
			<td class="its-td-align center">입점몰 Plus</td>
			<td class="its-td-align center">모든 기능 제한 없음</td>
			<td class="its-td-align center">큐레이션당 최대 3개까지 복수 설정 가능</td>
		</tr>
		<tr>
			<td class="its-td-align center">입점몰 Plus Lite</td>
			<td class="its-td-align center">모든 기능 제한 없음</td>
			<td class="its-td-align center">큐레이션당 최대 3개까지 복수 설정 가능</td>
		</tr>
		<tr>
			<td class="its-td-align center" rowspan="3">일반 쇼핑몰</td>
			<td class="its-td-align center">독립몰 Plus</td>
			<td class="its-td-align center">모든 기능 제한 없음</td>
			<td class="its-td-align center">큐레이션당 최대 3개까지 복수 설정 가능</td>
		</tr>
		<tr>
			<td class="its-td-align center">프리미엄몰 Plus</td>
			<td class="its-td-align center">모든 기능 제한 없음</td>
			<td class="its-td-align center">큐레이션당 최대 3개까지 복수 설정 가능</td>
		</tr>
		<tr>
			<td class="its-td-align center">무료몰 Plus</td>
			<td class="its-td-align center">'관리자가 직접 지정'만 사용 가능</td>
			<td class="its-td-align center">최대 1개 가능. 다른 조건으로 변경불가</td>
		</tr>
	</table>
	<div class="center mt10">
		<img align="absmiddle" class="hand" onclick="serviceUpgrade();" src="/admin/skin/default/images/common/btn_upgrade.gif">
	</div>
</div>