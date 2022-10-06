<?php /* Template_ 2.2.6 2022/05/17 12:29:11 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/select_auto.html 000018572 */ ?>
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
				<?php echo serviceLimit('A3')?>

				return;
			}
<?php }?>
			if(displayKind != 'bigdata_catalog'){
				cnt = $("#goodsSelectorAuto input[name=condition[]]:checkbox:checked").length;
				if(cnt > limit_condition){
					event.cancelBubble = false;
					if(limit_condition == 1){
						<?php echo serviceLimit('A3')?>

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
	if(!temp) return;
	if(temp.indexOf('∀') > -1){
		temp_arr = temp.split('Φ');
		$.each(temp_arr.reverse(),function(k,v){
			div = v.split('∀');
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
			$("#<?php echo $_GET["inputGoods"]?>").val(condition.join('Φ'));

<?php if($_GET["displayKind"]!='bigdata'&&$_GET["displayKind"]!='bigdata_catalog'){?>
<?php if($_GET["displayKind"]=='relation'){?>
				$("input[name='relation_type'][value='AUTO']").attr("checked",true).change();
<?php }else{?>
				$("select.contents_type").eq(tabIdx).val("auto").change();
<?php }?>

<?php if($_GET["displayKind"]!='relation_seller'){?>
				$("#<?php echo $_GET["auto_condition_use_id"]?>").val(1);
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
</script>
<div id="goodsSelectorAuto">
	<div>
	<table class="info-table-style" width="100%" border="0" cellpadding="0" cellspacing="0">
		<col width="100"/>
		<col width="50"/>
		<col width="60"/>
		<col />
		<col width="100"/>
		<tbody>
		<tr>
			<th class="its-th-align"><span class="rank">1</span>순위-노출조건</th>
			<td class="its-td-align center"><img src="/admin/skin/default/images/common/icon_move.gif"></td>
			<td class="its-td-align right condition_img">
				<img src="/admin/skin/default/images/design/display/icon_relation_recently.png" alt="최근본상품" />
			</td>
			<td class="its-td border_none">
				<ul class="condition_txt">
					<li>
						<label>
							<input type="checkbox" name="condition[]" value="view"/>
<?php if($TPL_VAR["displayKind"]!='bigdata'&&$TPL_VAR["displayKind"]!='bigdata_catalog'){?>
							<span class="kind_title">○○○고객이 최근 본</span> 상품에 대한 다른 고객의 행동
<?php }else{?>
							<span class="kind_title">○○○고객이 보고 있는</span> 이 상품을 <span class="act_title">본</span> 다른 고객의 행동
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
					<button type="button" class="chg_condition" >조건변경</button>
				</span>
				<input type="hidden" name="auto_condition[]" value="isFirst=1"/>
			</td>
		</tr>
		<tr>
			<th class="its-th-align"><span class="rank">2</span>순위-노출조건</td>
			<td class="its-td-align center"><img src="/admin/skin/default/images/common/icon_move.gif"></td>
			<td class="its-td-align right condition_img">
				<img src="/admin/skin/default/images/design/display/icon_relation_cart.png" alt="최근장바구니" />
			</td>
			<td class="its-td border_none">
				<ul class="condition_txt">
					<li>
						<label>
							<input type="checkbox" name="condition[]" value="cart"/>
<?php if($TPL_VAR["displayKind"]!='bigdata'&&$TPL_VAR["displayKind"]!='bigdata_catalog'){?>
							<span class="kind_title">○○○고객이 최근 장바구니에 담은</span> 상품에 대한 다른 고객의 행동
<?php }else{?>
							<span class="kind_title">○○○고객이 보고 있는</span> 이 상품을 <span class="act_title">장바구니에 담은</span> 다른 고객의 행동
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
					<button type="button" class="chg_condition" >조건변경</button>
				</span>
				<input type="hidden" name="auto_condition[]" value="isFirst=1"/>
			</td>
		</tr>
		<tr>
			<th class="its-th-align"><span class="rank">3</span>순위-노출조건</td>
			<td class="its-td-align center"><img src="/admin/skin/default/images/common/icon_move.gif"></td>
			<td class="its-td-align right condition_img">
				<img src="/admin/skin/default/images/design/display/icon_relation_wish.png" alt="최근위시리스트" />
			</td>
			<td class="its-td border_none">
				<ul class="condition_txt">
					<li>
						<label>
							<input type="checkbox" name="condition[]" value="wish"/>
<?php if($TPL_VAR["displayKind"]!='bigdata'&&$TPL_VAR["displayKind"]!='bigdata_catalog'){?>
							<span class="kind_title">○○○고객이 최근 위시리스트에 담은</span> 상품에 대한 다른 고객의 행동
<?php }else{?>
							<span class="kind_title">○○○고객이 보고 있는</span> 이 상품을 <span class="act_title">위시리스트에 담은</span> 다른 고객의 행동
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
					<button type="button" class="chg_condition" >조건변경</button>
				</span>
				<input type="hidden" name="auto_condition[]" value="isFirst=1"/>
			</td>
		</tr>
<?php if($TPL_VAR["displayKind"]!='bigdata'&&$TPL_VAR["displayKind"]!='bigdata_catalog'){?>
		<tr>
			<th class="its-th-align"><span class="rank">4</span>순위-노출조건</td>
			<td class="its-td-align center"><img src="/admin/skin/default/images/common/icon_move.gif"></td>
			<td class="its-td-align right condition_img">
				<img src="/admin/skin/default/images/design/display/icon_relation_restock.png" alt="최근재입고알림" />
			</td>
			<td class="its-td border_none">
				<ul class="condition_txt">
					<li>
						<label>
							<input type="checkbox" name="condition[]" value="restock"/>
							<span class="kind_title">○○○고객이 최근 ‘재입고알림요청’한</span> 상품에 대한 다른 고객의 행동
						</label>
					</li>
					<li class="condition_detail">
						<span class="condition_desc"></span>
					</li>
				</ul>
			</td>
			<td class="its-td-align center">
				<span class="btn medium cyanblue">
					<button type="button" class="chg_condition" >조건변경</button>
				</span>
				<input type="hidden" name="auto_condition[]" value="isFirst=1"/>
			</td>
		</tr>
		<tr>
			<th class="its-th-align"><span class="rank">5</span>순위-노출조건</td>
			<td class="its-td-align center"><img src="/admin/skin/default/images/common/icon_move.gif"></td>
			<td class="its-td-align right condition_img">
				<img src="/admin/skin/default/images/design/display/icon_relation_search.png" alt="최근검색결과" />
			</td>
			<td class="its-td border_none">
				<ul class="condition_txt">
					<li>
						<label>
							<input type="checkbox" name="condition[]" value="search"/>
							<span class="kind_title">○○○고객이 최근 검색한 결과 중 최상위</span> 상품에 대한 다른 고객의 행동
						</label>
					</li>
					<li class="condition_detail">
						<span class="condition_desc"></span>
					</li>
				</ul>
			</td>
			<td class="its-td-align center">
				<span class="btn medium cyanblue">
					<button type="button" class="chg_condition" >조건변경</button>
				</span>
				<input type="hidden" name="auto_condition[]" value="isFirst=1"/>
			</td>
		</tr>
<?php }?>
		<tr>
			<th class="its-th-align"><span class="rank">6</span>순위-노출조건</td>
			<td class="its-td-align center"><img src="/admin/skin/default/images/common/icon_move.gif"></td>
			<td class="its-td-align right condition_img">
				<img src="/admin/skin/default/images/design/display/icon_relation_buy.png" alt="최근구매한" />
			</td>
			<td class="its-td border_none">
				<ul class="condition_txt">
					<li>
						<label>
							<input type="checkbox" name="condition[]" value="order"/>
<?php if($TPL_VAR["displayKind"]!='bigdata'&&$TPL_VAR["displayKind"]!='bigdata_catalog'){?>
							<span class="kind_title">○○○고객이 최근 구매한</span> 상품에 대한 다른 고객의 행동
<?php }else{?>
							<span class="kind_title">○○○고객이 보고 있는</span> 이 상품을 <span class="act_title">구매한</span> 다른 고객의 행동
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
					<button type="button" class="chg_condition" >조건변경</button>
				</span>
				<input type="hidden" name="auto_condition[]" value="isFirst=1"/>
			</td>
		</tr>
<?php if($TPL_VAR["displayKind"]=='bigdata'||$TPL_VAR["displayKind"]=='bigdata_catalog'){?>
		<tr>
			<th class="its-th-align"><span class="rank">7</span>순위-노출조건</td>
			<td class="its-td-align center"><img src="/admin/skin/default/images/common/icon_move.gif"></td>
			<td class="its-td-align right condition_img">
				<img src="/admin/skin/default/images/design/display/icon_relation_review.png" alt="리뷰를 쓴" />
			</td>
			<td class="its-td border_none">
				<ul class="condition_txt">
					<li>
						<label>
							<input type="checkbox" name="condition[]" value="review"/>
							<span class="kind_title">○○○고객이 보고 있는</span> 이 상품을 <span class="act_title">리뷰 작성한</span> 다른 고객의 행동
						</label>
					</li>
					<li class="condition_detail">
						<span class="condition_desc"></span>
					</li>
				</ul>
			</td>
			<td class="its-td-align center">
				<span class="btn medium cyanblue">
					<button type="button" class="chg_condition" >조건변경</button>
				</span>
				<input type="hidden" name="auto_condition[]" value="isFirst=1"/>
			</td>
		</tr>
<?php }?>
<?php if($TPL_VAR["displayKind"]!='bigdata'&&$TPL_VAR["displayKind"]!='bigdata_catalog'){?>
		<tr>
			<th class="its-th-align"><span class="rank">7</span>순위-노출조건</td>
			<td class="its-td-align center"><img src="/admin/skin/default/images/common/icon_move.gif"></td>
			<td class="its-td-align right condition_img">
				<img src="/admin/skin/default/images/design/display/icon_relation_select.png" alt="관리자가" />
			</td>
			<td class="its-td border_none">
				<ul class="condition_txt">
					<li>
						<label>
							<input type="checkbox" name="condition[]" value="admin"/>
							<span class="admin_title">관리자가 직접 지정한</span> 기준에 대한 다른 고객의 행동
						</label>
					</li>
					<li class="condition_detail">
						<span class="condition_desc"></span>
					</li>
				</ul>
			</td>
			<td class="its-td-align center">
				<span class="btn medium cyanblue">
					<button type="button" class="chg_condition">조건변경</button>
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
		<tr>
			<td class="its-td-align center">O2O</td>
			<td class="its-td-align center">홈페이지 Shop</td>
			<td class="its-td-align center">모든 기능 제한 없음</td>
			<td class="its-td-align center">큐레이션당 최대 3개까지 복수 설정 가능</td>
		</tr>
	</table>
	<div class="center mt10">
		<img align="absmiddle" class="hand" onclick="serviceUpgrade();" src="/admin/skin/default/images/common/btn_upgrade.gif">
	</div>
</div>