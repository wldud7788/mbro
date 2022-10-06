<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/barcode/barcode_print.html 000022809 */ 
$TPL_listdata_1=empty($TPL_VAR["listdata"])||!is_array($TPL_VAR["listdata"])?0:count($TPL_VAR["listdata"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

	<script type="text/javascript">
		$(document).ready(function(){
			$('html').attr('moznomarginboxes', '');
			$('html').attr('mozdisallowselectionprint', '');
			

			//화면 로딩 후 바코드 형식이 맞지않는 코드가 1개 이상 존재 할 경우 바코드 형식 고지 페이지를 띄운다.
			var barcode_fail = '<?php echo $TPL_VAR["barcode_fail_count"]?>';			

			if(barcode_fail > 0){
				openDialog("바코드 형식", 'info_codeform', {"width":"500","height":"200","show" : "fade","hide" : "fade"});
			}


			//출력양식 설정 버튼
			$('#info_setting').click(function(){
				openDialog('바코드 출력양식 설정', 'print_form', {"width":"720","height":"540","show" : "fade","hide" : "fade"});
			});
			
			//출력양식 설정에서 출력용지 변경 시 기본 값 로딩
			$('select[name="form_id"]').change(function(){
				$.ajax({
					type : 'get',
					url  : '../barcode_process/load_printinfo',
					dataType : 'json',
					data : 'form_id='+$(this).val(),
					success: function(data){
						$('input[name="margin_top"]').val(data.margin_top);
						$('input[name="margin_bottom"]').val(data.margin_bottom);
						$('input[name="margin_left"]').val(data.margin_left);
						$('input[name="margin_right"]').val(data.margin_right);
					}
				});
			});

			//출력양식 설정에서 바코드 형식 변경 시 바코드 이미지 및 설정 값 변경
			$('select[name="code_id"]').change(function(){
				$('#barcode_img').attr('src', '../barcode_process/barcode_image?code_type='+$(this).val());
				$.ajax({
					type : 'get',
					url  : '../barcode_process/load_barcodeinfo',
					dataType : 'json',
					data : 'code_id='+$(this).val(),
					success: function(data){
						setBarcodeInfo('use_border', data.use_border, 'barcode_area', 'bd');
						setBarcodeInfo('use_text', data.use_text, 'text', 'hide');
						setBarcodeInfo('use_goods_name', data.use_goods_name, 'goods_name', 'hide');
						setBarcodeInfo('use_option_name', data.use_option_name, 'option_name', 'hide');
						setBarcodeInfo('use_goods_seq', data.use_goods_seq, 'goods_seq', 'hide');
					}
				});
			});

			//바코드 출력 용지 변경
			$('select[name="sel_print_form"]').change(function(){
				$.ajax({
					type : 'get',
					url  : '../barcode_process/set_printid',
					dataType : 'text',
					data : 'form_id='+$(this).val(),
					success: function(data){
						$('#barcode_form').submit();
					}
				});
			});

			//바코드 출력 개수
			$('#print_page_cnt').change(function(){
				$('#barcode_form').submit();
			});

			//바코드 출력 페이지수
			$('input[name="page_num"][value="all"]').click(function(){ 
				$('.contents > div').removeClass('hide'); 
				$('#page_num_val').val('');
			});
			$('#page_num_val').click(function(){ $('input[name="page_num"][value="select"]').attr('checked', true); });
			$('#page_num_val').change(function(){
				var len = $(this).val();
				
				if(len.split('-').length == 2){
					var num_f = len.split('-')[0];
					var num_l = len.split('-')[1];
				}else if(len.split('~').length == 2){
					var num_f = len.split('~')[0];
					var num_l = len.split('~')[1];
				}else{
					alert('형식이 올바르지 않습니다.\n시작페이지~마지막페이지 형식으로 입력해 주세요.');
					$(this).val('').focus();
					return false;
				}
				
				if($('.contents > div').length < num_l){
					alert('최대 페이지 이상 출력 할 수 없습니다.');			
					$(this).val('').focus();
					return false;
				}else if(num_f < 1){
					alert('최소 1 페이지부터 출력 해야 합니다.');
					$(this).val('').focus();
					return false;
				}else{
					$('.contents > div').each(function(idx){
						if(idx+1 < num_f || idx+1 > num_l)	$(this).addClass('hide');
						else 								$(this).removeClass('hide');
					});
				}
			});

			//바코드 출력 시작위치
			$('#print_start_num').change(function(){
				$('#barcode_form').submit();
			});

			//바코드 출력 버튼
			$('#btn_print').click(function(){
				var mode = $('#mode').val();

				if(mode == 'all'){
					if($('input[name="page_num"]:checked').val() == 'select' ){
						var page_len = $('input[name="page_num_val"]').val();
						if( page_len == ''){
							alert('출력 할 범위를 입력해 주세요.');
							return false;
						}						
					}
				}

				if (navigator.userAgent.toLowerCase().indexOf("chrome") != -1) onStartPrint();
				window.print();
				if (navigator.userAgent.toLowerCase().indexOf("chrome") != -1) onEndPrint();
			});
			
			//window.print 출력 시 이벤트 분기 (크롬, 익스 크로스 브라우징 용)
			if (navigator.userAgent.toLowerCase().indexOf("chrome") != -1) {
				//var mediaQueryList = window.matchMedia('print');
				//mediaQueryList.addListener(function(mql) {
					//if (mql.matches) {
						//onStartPrint();
						//return false;
					//} else {
						//onEndPrint();
						//return false;
					//}
				//});
			}else{
				//프린트 전후 처리
				window.onbeforeprint = function(){
					onStartPrint();
				};
				window.onafterprint = function(){
					onEndPrint();
				};
			}		
			
		});

		function onStartPrint(){
			$('.header').hide();
			$('html').css({
				'overflow-y' : 'auto'
			});
			$('.contents').removeClass('print');
		}

		function onEndPrint(){
			$('.header').show();
			$('.contents').addClass('print');
			$('html').css({
				'overflow-y' : 'hidden'
			});
		}		

		function changeBarcodeView(obj, className, chgClass){

			if($(obj).filter(':checked').length > 0){
				$('.'+className).removeClass(chgClass);
			}else{
				$('.'+className).addClass(chgClass);
			}
			
		}

		function setBarcodeInfo(code, val, className, chgClass){
			if(val == 'Y')	$('input[name="'+code+'"').attr('checked', true);
			else			$('input[name="'+code+'"').attr('checked', false);

			changeBarcodeView($('input[name="'+code+'"'), className, chgClass);
		}
	</script>
	<style type="text/css" media="all">
		html { overflow: hidden }
		/* 바코드 출력영역 */
		.contents.print { height: 600px; overflow-y: auto; }
		
		.contents > div { 
			page-break-after: always;
			margin: 0 auto;
			padding: <?php echo $TPL_VAR["print_info"]["margin_top"]?>mm <?php echo $TPL_VAR["print_info"]["margin_right"]?>mm <?php echo $TPL_VAR["print_info"]["margin_bottom"]?>mm <?php echo $TPL_VAR["print_info"]["margin_left"]?>mm;
		}
		.contents > div:last-child { page-break-after: auto; }

		.contents div.form34 table { margin: 0px; padding: 0px; width: 100%; border-collapse: collapse; table-layout: fixed; }
		.contents div.form34 table td { position: relative; height: 70mm; padding-left: 4mm; padding-right: 4mm;}
		.contents div.form34 table td > div { display: inline-block; width: 100%; border: 1px solid #000; text-align: center; }
		.contents div.form34 table td > div > div { display: inline-block; width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis }
		.contents div.form34 table td > div > div > img { margin: 5px 0px 0px 0px; }
		.contents div.form34 table td > div.bd { border: 0px; }

		.contents div.form39 table { margin: 0px; padding: 0px; width: 100%; border-collapse: collapse; table-layout: fixed; }
		.contents div.form39 table td { position: relative; height: 30.1mm; padding-left: 4mm; padding-right: 4mm;}
		.contents div.form39 table td > div { display: inline-block; width: 100%; border: 1px solid #000; text-align: center; }
		.contents div.form39 table td > div > div { display: inline-block; width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis }
		.contents div.form39 table td > div > div > img {margin: 5px 0px 0px 0px; }
		.contents div.form39 table td > div.bd { border: 0px; }

		.contents div.form410 table { margin: 0px; padding: 0px; width: 100%; border-collapse: collapse; table-layout: fixed; }
		.contents div.form410 table td { position: relative; height: 26.9mm; padding-left: 4mm; padding-right: 4mm; }
		.contents div.form410 table td > div { display: inline-block; width: 100%; border: 1px solid #000; text-align: center; }
		.contents div.form410 table td > div > div { display: inline-block; width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis }
		.contents div.form410 table td > div > div > img { margin: 4px 0px 0px 0px; }
		.contents div.form410 table td > div.bd { border: 0px; }

		.contents div.formroll { margin: 0px; padding: 20px; }
		.contents div.formroll > div { text-align: center;  border: 1px solid #000; margin: 10px 0px; }
		.contents div.formroll > div.bd { border: 0px; }

		/* 출력양식 설정 팝업 */
		h4 { margin-bottom: 5px; }
		.list-table-style { margin-bottom: 10px; }
		.list-table-style td { padding: 0px 10px; border: 1px solid #eaeaea }
		.list-table-style input[type='text'] { width: 40px }
		.list-table-style select {
			color:#797d86; 
			font-size:11px; 
			appearance:none; 
			-webkit-appearance: none; 
			-moz-appearance: none; 
			height:22px !important;
			width: 90%;
			background: #ffffff url('/admin/skin/default/images/common/icon/admin_select_n.gif') no-repeat right 8px center;
		}

		.list-table-style select.small {width: 135px;}
		.list-table-style select::-ms-expand {display: none;}
		.list-table-style label { line-height: 23px; vertical-align: middle; }
		.list-table-style input[type='checkbox'] { margin-right: 4px; }

		.barcode_area { text-align: center; vertical-align: middle; height: 80%; line-height: 80%; display: inline-block; border: 1px solid #000; }
		.barcode_area.bd { border: 0px; }
		.barcode_area img { margin-top: 10px }
		.barcode_area span { line-height: 18px; }
			
	</style>
<?php if($TPL_VAR["print_info"]["id"]=='formroll'){?>
	<style type="text/css">
		.contents.print { overflow-y: auto; }
		@page {
			size: auto;
			margin: 0mm;
		}

		@media print {
			.formroll { page-break-after: always; }
		}
	</style>
<?php }else{?>
	<style type="text/css">
		@page {
			size: A4;
			margin: 0mm;
		}

		@media print {
			html, body, .contents {
				width: 210mm;
				height: 297mm;
			}
		}
	</style>
<?php }?>
	<form id="barcode_form" name="barcode_form" method="post" action="">
		<input type="hidden" name="" value=""/>
		<input type="hidden" name="mode" value="<?php echo $TPL_VAR["mode"]?>"/>
		<input type="hidden" name="perpage" value="<?php echo $TPL_VAR["perpage"]?>"/>
		<input type="hidden" name="keyword" value="<?php echo $TPL_VAR["keyword"]?>"/>
		<input type="hidden" name="search_type" value="<?php echo $TPL_VAR["search_type"]?>"/>
		<input type="hidden" name="gtype" value="<?php echo $TPL_VAR["gtype"]?>"/>
		<input type="hidden" name="btype" value="<?php echo $TPL_VAR["btype"]?>"/>
		<input type="hidden" name="bsubtype1" value="<?php echo $TPL_VAR["bsubtype1"]?>"/>
		<input type="hidden" name="bsubtype2" value="<?php echo $TPL_VAR["bsubtype2"]?>"/>
		<input type="hidden" name="goods_seq_list" value="<?php echo $TPL_VAR["goods_seq_list"]?>" />
		<input type="hidden" name="option_seq_list" value="<?php echo $TPL_VAR["option_seq_list"]?>" />
		<input type="hidden" name="goods_stock" value="<?php echo $TPL_VAR["goods_stock"]?>" />

		<div class="header" style="padding: 10px; border-bottom: 1px solid #000">
			<b>출력양식</b>
			<select name="sel_print_form">
				<option value="form39"		<?php if($TPL_VAR["print_info"]["id"]=='form39'){?>selected="selected"<?php }?> >[폼텍3104] A4:3x9</option>
				<option value="form410"		<?php if($TPL_VAR["print_info"]["id"]=='form410'){?>selected="selected"<?php }?> >[폼텍3102] A4:4x10</option>
				<option value="form34"		<?php if($TPL_VAR["print_info"]["id"]=='form34'){?>selected="selected"<?php }?> >[폼텍3112] A4:3x4</option>
				<option value="formroll"	<?php if($TPL_VAR["print_info"]["id"]=='formroll'){?>selected="selected"<?php }?> >롤지</option>
			</select>
			<span id="info_setting" class="btn small gray"><button type="button">설정</button></span>
			<span style="margin-left: 50px"></span>
<?php if($TPL_VAR["mode"]=='all'){?>
				<b>출력수</b>
				<input type="text" id="print_page_cnt" name="print_page_cnt" value="<?php echo $TPL_VAR["print_page_cnt"]?>" style="width: 50px; text-align: right"/>개
				<span style="margin-left: 50px"></span>
				<b>페이지</b>
				<label><input type="radio" name="page_num" value="all" checked="checked"/> 전체</label>
				<label>
					<input type="radio" name="page_num" value="select"/>
					<input type="text" id="page_num_val" name="page_num_val" value="" style="width: 100px;"/> 
				</label>
				(총 <?php echo $TPL_VAR["total_page"]?>페이지)
				<span style="margin-left: 50px"></span>
<?php }elseif($TPL_VAR["mode"]=='select'){?>
				<b>출력시작위치</b>
				<?php echo $TPL_VAR["print_start_num"]?>

				<span style="margin-left: 400px"></span>
<?php }?>
			<span id="btn_print" class="btn small cyanblue"><button type="button" style="width: 100px">인쇄</button></span>
		</div>
		
		<div class="contents print">
<?php if($TPL_VAR["listdata"]){?>
<?php if($TPL_listdata_1){$TPL_I1=-1;foreach($TPL_VAR["listdata"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_VAR["print_info"]["id"]=='formroll'){?>
							<div class="<?php echo $TPL_VAR["print_info"]["id"]?>">
								<div class="<?php if($TPL_VAR["barcode_info"]["use_border"]!='Y'){?>bd<?php }?>">
									<div><?php echo $TPL_V1["barcode_img"]?></div>
									<div><span class="<?php if($TPL_VAR["barcode_info"]["use_text"]!='Y'){?>hide<?php }?>"><?php echo $TPL_V1["goods_code"]?><?php echo $TPL_V1["option_code"]?></span></div>
									<div>
										<span class="<?php if($TPL_VAR["barcode_info"]["use_goods_name"]!='Y'){?>hide<?php }?>"><?php echo $TPL_V1["goods_name"]?></span>&nbsp;
										<span class="<?php if($TPL_VAR["barcode_info"]["use_option_name"]!='Y'){?>hide<?php }?>"><?php echo $TPL_V1["option_title"]?></span>
									</div>
									<div><span class="<?php if($TPL_VAR["barcode_info"]["use_goods_seq"]!='Y'){?>hide<?php }?>"><?php echo $TPL_V1["goods_seq"]?></span></div>
								</div>
							</div>
<?php }else{?>
<?php if($TPL_I1== 0||$TPL_I1%$TPL_VAR["total_print_cell"]== 0){?>
						<div class="<?php echo $TPL_VAR["print_info"]["id"]?>">
							<table>
<?php }?>
<?php if($TPL_I1== 0||$TPL_I1%($TPL_VAR["print_info"]["cellcount"])== 0){?><tr><?php }?>
							<td>
<?php if($TPL_V1["display"]!='none'){?>
								<div class="<?php if($TPL_VAR["barcode_info"]["use_border"]!='Y'){?>bd<?php }?>">
									<div><?php echo $TPL_V1["barcode_img"]?></div>
									<div><span class="<?php if($TPL_VAR["barcode_info"]["use_text"]!='Y'){?>hide<?php }?>"><?php echo $TPL_V1["goods_code"]?><?php echo $TPL_V1["option_code"]?></span></div>
									<div>
										<span class="<?php if($TPL_VAR["barcode_info"]["use_goods_name"]!='Y'){?>hide<?php }?>"><?php echo $TPL_V1["goods_name"]?></span>&nbsp;
										<span class="<?php if($TPL_VAR["barcode_info"]["use_option_name"]!='Y'){?>hide<?php }?>"><?php echo $TPL_V1["option_title"]?></span>
									</div>
									<div><span class="<?php if($TPL_VAR["barcode_info"]["use_goods_seq"]!='Y'){?>hide<?php }?>"><?php echo $TPL_V1["goods_seq"]?></span></div>
								</div>
<?php }?>
							</td>
<?php if($TPL_I1> 0&&($TPL_I1+ 1)%($TPL_VAR["print_info"]["cellcount"])== 0){?></tr><?php }?>	
<?php if($TPL_I1!= 0&&($TPL_I1+ 1)%$TPL_VAR["total_print_cell"]== 0||$TPL_I1==$TPL_listdata_1- 1){?>
							</table>
						</div>
						
<?php }?>
<?php }?>
<?php }}?>
<?php }else{?>
				<table>
					<tr>
						<td colspan="4"><p>출력 할 바코드가 없습니다.</p></td>
					</tr>
				</table>
<?php }?>
		</div>
	</form>

	<div class="hide" id="print_form" class="print_form">
		<form id="formFrm" name="formFrm" method="post" action="../barcode_process/set_barcode_form" target="actionFrame">
			<input type="hidden" id="mode" value="<?php echo $TPL_VAR["mode"]?>"/>
			<h4>■ 출력양식</h4>
			<table class="list-table-style" cellspacing="0" style="border-collapse: collapse;">
				<colgroup>
					<col width="100px"/>
					<col width="100px"/>
					<col width="*"/>
				</colgroup>
				<tbody class="ltb">
					<tr class="list-row">
						<td>출력용지</td>
						<td colspan="2">
							<select class="small" id="form_id" name="form_id">
								<option value="form39"		<?php if($TPL_VAR["print_info"]["id"]=='form39'){?>selected="selected"<?php }?> >[폼텍3104] A4:3x9</option>
								<option value="form410"		<?php if($TPL_VAR["print_info"]["id"]=='form410'){?>selected="selected"<?php }?> >[폼텍3102] A4:4x10</option>
								<option value="form34"		<?php if($TPL_VAR["print_info"]["id"]=='form34'){?>selected="selected"<?php }?> >[폼텍3112] A4:3x4</option>
								<option value="formroll"	<?php if($TPL_VAR["print_info"]["id"]=='formroll'){?>selected="selected"<?php }?> >롤지</option>
							</select>
							<span style="font-size: 9pt">브라우저 인쇄화면 용지 크기와 선택하신 출력용지 크기가 동일해야 합니다.</span>
						</td>						
					</tr>
					<tr class="list-row">
						<td>레이아웃</td>
						<td colspan="2">세로 방향</td>
					</tr>
					<tr class="list-row">
						<td>상단여백</td>
						<td><input type="text" name="margin_top" value="<?php echo $TPL_VAR["print_info"]["margin_top"]?>"/> mm</td>
						<td rowspan="4">
							브라우저 인쇄여백 보다 우선 적용됩니다.<br/>
							단, 크롬, 오페라 브라우저의 경우 인쇄여백을 ‘기본값’으로 설정해 주셔야 적용됩니다.
						</td>
					</tr>
					<tr class="list-row">
						<td>좌측여백</td>
						<td><input type="text" name="margin_left" value="<?php echo $TPL_VAR["print_info"]["margin_left"]?>"/> mm</td>
					</tr>
					<tr class="list-row">
						<td>하단여백</td>
						<td><input type="text" name="margin_bottom" value="<?php echo $TPL_VAR["print_info"]["margin_bottom"]?>"/> mm</td>
					</tr>
					<tr class="list-row">
						<td>우측여백</td>
						<td><input type="text" name="margin_right" value="<?php echo $TPL_VAR["print_info"]["margin_right"]?>"/> mm</td>
					</tr>
				</tbody>
			</table>
			<h4>■ 출력내용</h4>
			<table class="list-table-style" cellspacing="0" style="border-collapse: collapse;">
				<colgroup>
					<col width="100px"/>
					<col width="200px"/>
					<col width="*"/>
				</colgroup>
				<tbody class="ltb">
					<tr class="list-row">
						<td>바코드 타입</td>
						<td>
							<?php echo $TPL_VAR["barcode_info"]["code_name"]?>

							<input type="hidden" name="code_id" value="<?php echo $TPL_VAR["barcode_info"]["id"]?>"/>
						</td>		
						<td rowspan="3">
							<div class="barcode_area <?php if($TPL_VAR["barcode_info"]["use_border"]!='Y'){?>bd<?php }?>">
								<img id="barcode_img" src="../barcode_process/barcode_image?code_type=<?php echo $TPL_VAR["barcode_info"]["id"]?>"/><br/>
								<span class="text <?php if($TPL_VAR["barcode_info"]["use_text"]!='Y'){?>hide<?php }?>">546404_063</span><br/>
								<span class="goods_name <?php if($TPL_VAR["barcode_info"]["use_goods_name"]!='Y'){?>hide<?php }?>">티셔츠</span>&nbsp;
								<span class="option_name <?php if($TPL_VAR["barcode_info"]["use_option_name"]!='Y'){?>hide<?php }?>">화이트/M</span><br/>
								<span class="goods_seq <?php if($TPL_VAR["barcode_info"]["use_goods_seq"]!='Y'){?>hide<?php }?>">123</span>
							</div>
						</td>
					</tr>
					<tr class="list-row">
						<td>테두리</td>
						<td><label><input class="chk_barcode" onclick="changeBarcodeView(this, 'barcode_area', 'bd');" type="checkbox" target="" name="use_border" value="Y" <?php if($TPL_VAR["barcode_info"]["use_border"]=='Y'){?>checked="checked"<?php }?>/>사용</label></td>
					</tr>
					<tr class="list-row">
						<td>추가 정보</td>
						<td>
							<label><input class="chk_barcode" onclick="changeBarcodeView(this, 'text', 'hide');" type="checkbox" name="use_text" value="Y" <?php if($TPL_VAR["barcode_info"]["use_text"]=='Y'){?>checked="checked"<?php }?>/>바코드텍스트</label><br/>
							<label><input class="chk_barcode" onclick="changeBarcodeView(this, 'goods_name', 'hide');" type="checkbox" name="use_goods_name" value="Y" <?php if($TPL_VAR["barcode_info"]["use_goods_name"]=='Y'){?>checked="checked"<?php }?>/>상품명</label>+
							<label><input class="chk_barcode" onclick="changeBarcodeView(this, 'option_name', 'hide');" type="checkbox" name="use_option_name" value="Y" <?php if($TPL_VAR["barcode_info"]["use_option_name"]=='Y'){?>checked="checked"<?php }?>/>옵션</label><br/>
							<label><input class="chk_barcode" onclick="changeBarcodeView(this, 'goods_seq', 'hide');" type="checkbox" name="use_goods_seq" value="Y" <?php if($TPL_VAR["barcode_info"]["use_goods_seq"]=='Y'){?>checked="checked"<?php }?>/>상품번호</label>
						</td>						
					</tr>
				</tbody>
			</table>
			<div style="text-align: center">
				<span class="btn small cyanblue"><button type="submit" style="width: 100px">저장</button></span>
			</div>
		</form>
	</div>
	<div id="info_codeform" class="hide">
		<h4>현재 바코드 형식에 맞지 않는 코드는 <span class="red"><?php echo $TPL_VAR["barcode_fail_count"]?></span> 개 입니다.</h4>
		<?php echo $TPL_VAR["barcode_info"]["code_name"]?>코드가 지원하는 형식은 아래와 같습니다.
		<div style="text-align: center; margin: 10px; padding: 10px; border: 1px solid #dadada">
<?php if($TPL_VAR["barcode_info"]["id"]=='code39'){?>
				숫자, 영문(대문자), 특수문자 ( - SPACE $ / % )
<?php }elseif($TPL_VAR["barcode_info"]["id"]=='code128_a'){?>
				숫자, 영문(대문자), 특수문자 ( - SPACE $ / % )
<?php }elseif($TPL_VAR["barcode_info"]["id"]=='code128_b'){?>
				숫자, 영문(대문자, 소문자), 특수문자 ( - SPACE $ / % )
<?php }elseif($TPL_VAR["barcode_info"]["id"]=='code128_c'){?>
				숫자 (짝수 개의 숫자를 입력해야 함)
<?php }elseif($TPL_VAR["barcode_info"]["id"]=='isbn'){?>
				숫자 (978로 시작하는 13자리여야 함)
<?php }?>
		</div>
	</div>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>