<?php /* Template_ 2.2.6 2022/05/25 16:36:57 /www/music_brother_firstmall_kr/admin/skin/default/barcode/barcode_search_form.html 000008038 */ ?>
<div class="search-form-container">
	<table class="search-form-table">
		<tr>
			<td width="810">
				<table class="sf-keyword-table">
					<tr>
						<td class="sfk-td-txt">
							<div class="relative">
								<input type="text" name="keyword" id="search_keyword" value="<?php echo $_GET["keyword"]?>" title="상품명, 상품번호, 상품코드" />
								<!-- 검색어 입력시 레이어 박스 : start -->
								<div class="searchLayer hide">
									<input type="hidden" name="search_type" id="search_type" value="<?php echo $_GET["search_type"]?>" />
									<ul class="searchUl">
										<li><a class="link_keyword" s_type="all" href="#"><span class="txt_keyword"></span> <span class="txt_title">-전체검색</span></a></li>
										<li><a class="link_keyword" s_type="goods_name" href="#">상품명: <span class="txt_keyword"></span> <span class="txt_title">-상품명 찾기</span></a></li>
										<li><a class="link_keyword" s_type="goods_seq" href="#">상품번호: <span class="txt_keyword"></span> <span class="txt_title">-상품번호 찾기</span></a></li>
										<li><a class="link_keyword" s_type="goods_code" href="#">상품코드: <span class="txt_keyword"></span> <span class="txt_title">-상품코드 찾기</span></a></li>
									</ul>
								</div>
								<!-- 검색어 입력시 레이어 박스 : end -->
							</div>
						</td>
						<td class="sfk-td-btn"><button id="search_btn" type="button"><span>검색</span></button></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table class="search-form-table search_detail_form" id="serch_tab">
		<colgroup>
			<col width="70"/><col width="120"/>
			<col width="60"/><col />
		</colgroup>
		<tr id="goods_search_form" style="display:block;">
		<tr>
			<th>상품구분</th>
			<td>
				<select style="vertical-align:middle;width:100px;" name="gtype">
					<option <?php if($TPL_VAR["gtype"]==''){?>selected="selected"<?php }?> value="">전체</option>
					<option <?php if($TPL_VAR["gtype"]=='goods'){?>selected="selected"<?php }?> value="goods">실물배송</option>
					<option <?php if($TPL_VAR["gtype"]=='coupon'){?>selected="selected"<?php }?> value="coupon">티켓배송</option>
				</select>
			</td>
			<th>바코드</th>
			<td>
				<label><input type="radio" name="btype" <?php if($TPL_VAR["btype"]==''){?>checked="checked"<?php }?> value=""/> 전체</label>
				<label><input type="radio" id="btype1" name="btype" <?php if($TPL_VAR["btype"]=='Y'){?>checked="checked"<?php }?> value="Y"/> 바코드 있음</label>
				<span class="bsubtype_wrap">
					<label>(<input type="checkbox" name="bsubtype1" parent="btype1" <?php if($TPL_VAR["btype"]=='Y'&&$TPL_VAR["bsubtype1"]=='Y'){?>checked="checked"<?php }?> value="Y"/> 기본코드</label>
					<label><input type="checkbox" name="bsubtype2" parent="btype1" <?php if($TPL_VAR["btype"]=='Y'&&$TPL_VAR["bsubtype2"]=='Y'){?>checked="checked"<?php }?> value="Y"/> 옵션코드)</label>
				</span>
				<label><input type="radio" id="btype2" name="btype" <?php if($TPL_VAR["btype"]=='N'){?>checked="checked"<?php }?> value="N"/> 바코드 없음</label>
				<span class="bsubtype_wrap">
					<label>(<input type="checkbox" name="bsubtype1" parent="btype2" <?php if($TPL_VAR["btype"]=='N'&&$TPL_VAR["bsubtype1"]=='Y'){?>checked="checked"<?php }?> value="Y"/> 기본코드</label>
					<label><input type="checkbox" name="bsubtype2" parent="btype2" <?php if($TPL_VAR["btype"]=='N'&&$TPL_VAR["bsubtype2"]=='Y'){?>checked="checked"<?php }?> value="Y"/> 옵션코드)</label>
				</span>
			</td>
		</tr>
	</table>
</div>

<script type='text/javascript'>
	$('input[name="btype"]').click(function(){
		var parentId = $(this).attr('id');
		$('.bsubtype_wrap input').attr('checked', false);
		$('input[name="bsubtype1"][parent="'+parentId+'"]').attr('checked', true);
	});

	$('.bsubtype_wrap input').click(function(){
		var tmp_parent = $(this).attr('parent');
		$('#'+tmp_parent).attr('checked', true);
		$('input[name="bsubtype1"], input[name="bsubtype2"]').each(function(){
			if(tmp_parent != $(this).attr('parent')){
				$(this).attr('checked', false);
			}
		});
	});

	$('#search_btn').click(function(){
		if($('input[name="btype"]:checked').val() != ''){
			if($('.bsubtype_wrap input[type="checkbox"]:checked').length == 0){
				openDialogAlert("서브 조건 하나는 반드시 선택해야 합니다.",400,150,'',[]);
				return false;
			}
		}
		$(".chk").attr('checked', false);
		$("#barcodeFrm").attr('method', 'get');
		$('#barcodeFrm').submit();
	});

	// 검색어 레이어 박스 : start
	$("#search_keyword").keyup(function () {
		if ($(this).val()) {
			$('.txt_keyword').text($(this).val());
			searchLayerOpen();
		}else{
			$('.searchLayer').hide();
		}
	});

	$("#search_keyword").focus(function () {
		if ($(this).val() && $(this).val()!=$(this).attr('title')) {
			$('.txt_keyword').text($(this).val());
			searchLayerOpen();
		}
	});

	$("a.link_keyword").click(function () {
		var sType = $(this).attr('s_type');
		$('#search_type').val(sType);
		$('.searchLayer').hide();
		$(".chk").attr('checked', false);
		$("#barcodeFrm").attr('method', 'get');
		$("#barcodeFrm").submit();
	});

	$("#search_keyword").blur(function(){
		if("<?php echo $_GET["keyword"]?>" == $("#search_keyword").val()){
			$(".search_type_text").show();
		}
		setTimeout(function(){
			$('.searchLayer').hide()}, 500
		);
	});

	var offset = $("#search_keyword").offset();
	$('.search_type_text').css({
		'position' : 'absolute',
		'z-index' : 999,
		'left' : 0,
		'top' : 0,
		'width':$("#search_keyword").width()-1,
		'height':$("#search_keyword").height()-5
	});

<?php if($_GET["search_type"]){?>
	$('.search_type_text').show();
<?php }?>

		$(".search_type_text").click(function () {
			$(".search_type_text").hide();
			$("#search_keyword").focus();
		});

		$(".searchLayer ul li").hover(function() {
			$(".searchLayer ul li").removeClass('hoverli');
			$(this).addClass('hoverli');
		});

		$("#search_keyword").keydown(function (e) {
			var searchbox = $(this);

			switch (e.keyCode) {
				case 40:
					if($('.searchUl').find('li.hoverli').length == 0){
						$('.searchUl').find('li:first-child').addClass('hoverli');
					}else{
						if($('.searchUl').find('li:last-child').hasClass("hoverli") ){
							$('.searchUl').find('li::last-child.hoverli').removeClass('hoverli');
							$('.searchUl').find('li:first-child').addClass('hoverli');
						}else{
							$('.searchUl').find('li:not(:last-child).hoverli').removeClass('hoverli').next().addClass('hoverli');
						}
					}
					break;
				case 38:
					if($('.searchUl').find('li.hoverli').length == 0){
						$('.searchUl').find('li:last-child').addClass('hoverli');
					}else{
						if($('.searchUl').find('li:first-child').hasClass("hoverli")){
							$('.searchUl').find('li::first-child.hoverli').removeClass('hoverli');
							$('.searchUl').find('li:last-child').addClass('hoverli');
						}else{
							$('.searchUl').find('li:not(:first-child).hoverli').removeClass('hoverli').prev().addClass('hoverli');
						}
					}
					break;
				case 13 :
					var index=0;
					$('.searchUl').find('li').each(function(){
						if($(this).hasClass("hoverli")){
							index=$(this).index();
						}
					});

					$('.searchUl').find('li>a').eq(index).click();
					e.keyCode = null;
					//return false;
					break;
			}
		});
		// 검색어 레이어 박스 : end

		function searchLayerOpen(){
			var offset = $("#search_keyword").offset();
			if( offset) {
				$('.searchLayer').css({
					'position' : 'absolute',
					'z-index' : 999,
					'left' : -1,
					'top' : '100%',
					'width':$("#search_keyword").width()
				}).show();
			}
		}
</script>