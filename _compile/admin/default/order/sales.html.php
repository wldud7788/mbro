<?php /* Template_ 2.2.6 2022/05/17 12:36:41 /www/music_brother_firstmall_kr/admin/skin/default/order/sales.html 000081077 */ 
$TPL_salesloop_1=empty($TPL_VAR["salesloop"])||!is_array($TPL_VAR["salesloop"])?0:count($TPL_VAR["salesloop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<!-- 2021.12.30 11월 3차 패치 by 김혜진 -->
<script type="text/javascript" src="/app/javascript/plugin/validate/jquery.validate.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="utf8"></script>
<?php if($TPL_VAR["config_system"]["pgCompany"]=="lg"){?><script type="text/javascript" src="//pgweb.dacom.net/WEB_SERVER/js/receipt_link.js"></script><?php }?>
<?php if($TPL_VAR["config_system"]["pgCompany"]=="allat"){?> <?php }?>
<script type="text/javascript">
	var search_type				= "<?php echo $TPL_VAR["sc"]["search_type"]?>";

	//기본검색설정
	var default_search_pageid	= "sales";
	var default_obj_width		= 750;
	var default_obj_height		= 330;

	$(document).ready(function() {

		$('select#multichkec').change(function() {
			checkAll(this, '.checkeds');
			$('#checkboxAll').attr("checked",$(this).val());
		});

		$('#checkboxAll').live('click', function() {
			checkAll(this, '.checkeds');
		});

		$(".star_select").click(function(){
			var status = "";
			if($(this).hasClass("checked")){
				$(this).removeClass("checked");
				status = "none";
			}else{
				$(this).addClass("checked");
				status = "checked";
			}

			$.ajax({
				type: "get",
				url: "../order/sales_favorite",
				data: "status="+status+"&seq="+$(this).attr("seq"),
				success: function(result){
					//alert(result);
				}
			});
		});

		$("#order_star").click(function(){
			var status = "";
			if($(this).hasClass("checked")){
				$(this).removeClass("checked");
				status = "asc";
			}else{
				$(this).addClass("checked");
				status = "desc";
			}
			location.href = "../order/sales?orderby=favorite_chk "+status;
		});

		$("#sales_multi_delete").click(function(){
			var delidar = '';
			$('.checkeds').each(function(e, el) {
				if( $(el).attr('checked') == 'checked'){
					delidar += $(el).val() + ",";
				}
			});
			if(!delidar){
				alert('매출증빙 자료를 선택해 주세요.');
				return false;
			}

			if(confirm("정말로 삭제하시겠습니까? ")) {
				var id = $(this).attr('board_id');
				$.ajax({
					'url' : '../sales_process/sales_multi_delete',
					'data' : {'delidar':delidar},
					'type' : 'post',
					'dataType': 'json',
					'success' : function(data) {
						if(data.result) {
							alert(data.msg);
							document.location.reload();
						}else{
							alert(data.msg);
						}
					}
				});
			}
		});

		$(".cashreceiptBtn").click(function(){
<?php if($TPL_VAR["private_masking"]){?>
			openDialogAlert("권한이 없습니다.",400,150,function(){});
<?php }else{?>
			$frm	= $('form[name="cashreceiptform"]');
			$('input[name="mode"]', $frm).val('add');
			$('input[name="seq"]', $frm).val('');
			$('input[name="order_date"]', $frm).val('');
			$('.order_date', $frm).hide();
			$('#personallay').show();
			$('#businesslay').hide();
			$('.vat_type_label').show();
			$('#vat_type_cash').html("");
			document.cashreceiptform.cuse[0].checked	= true;
			$('input[name="creceipt_number[1]"]', $frm).val('');
			$('input[name="creceipt_number[0]"]', $frm).val('');
			document.cashreceiptform.vat_type[1].checked	= true;
			$('input[name="name"]', $frm).val('');
			$('input[name="email"]', $frm).val('');
			$('input[name="phone"]', $frm).val('');
			$('input[name="goodsname"]', $frm).val('');
			$('input[name="amount"]', $frm).val('');
			$('input[name="supply"]', $frm).val('');
			$('input[name="surtax"]', $frm).val('');
			$('#supplylay').val('');
			$('#surtaxlay').val('');
			$('input[name="order_date"]', $frm).css("display", "block");
			$('#order_date_cash').css("display", "none");
			$('input[name="amount"]', $frm).attr("readOnly", false);
			$('.selected_order_seq', $frm).val('');
			$('.selected_order_seq_txt', $frm).hide();
			$('.has_order').show();
			$("input[name='name']").attr("disabled",false);
			$("input[name='email']").attr("disabled",false);
			$("input[name='phone']").attr("disabled",false);
			$("input[name='creceipt_number[0]']").attr("disabled",false);
			$('#download_create_cash').val('등록');
			openDialog("현금영수증 수동발급 <span class='desc'>현금영수증을 수동발급합니다.</span>", "cashreceiptlay", {"width":"500","height":"550"});
<?php }?>
			});

			$("#taxBtn").click(function(){
<?php if($TPL_VAR["private_masking"]){?>
				openDialogAlert("권한이 없습니다.",400,150,function(){});
<?php }else{?>
				$frm	= $('form[name="taxform"]');
				document.taxform.vat_type[1].checked	= true;
				$('#tax_gubun').show();
				$('input[name="order_seq"]', $frm).css("display", "block");
				$('#order_seq_tax').css("display", "none");
				$('input[name="amount"]', $frm).attr("readOnly", false);
				$('#tstep_tax').html("신청서 작성");

				$('input[name="mode"]', $frm).val('add');
				$('input[name="seq"]', $frm).val('');
				$('input[name="co_name"]', $frm).val('');
				$('input[name="busi_no"]', $frm).val('');
				$('input[name="co_ceo"]', $frm).val('');
				$('input[name="co_status"]', $frm).val('');
				$('input[name="co_type"]', $frm).val('');
				$('input[name="Post_number"]', $frm).val('');
				$('input[name="Zipcode[]"]', $frm).eq(0).val('');
				$('input[name="Address_type"]', $frm).val('');
				$('input[name="Address"]', $frm).val('');
				$('input[name="Address_street"]', $frm).val('');
				$('input[name="Address_detail"]', $frm).val('');
				$('input[name="person"]', $frm).val('');
				$('input[name="email"]', $frm).val('');
				$('input[name="phone"]', $frm).val('');
				$('input[name="amount"]', $frm).val('');
				$('input[name="supply"]', $frm).val('');
				$('input[name="surtax"]', $frm).val('');
				$('#supplylay2').val('');
				$('#surtaxlay2').val('');
				$('.selected_order_seq', $frm).val('');
				$('.selected_order_seq_txt', $frm).hide();
				$('.has_order', $frm).show();
				$("input[name='co_ceo']").attr("disabled",false);
				$("input[name='person']").attr("disabled",false);
				$("input[name='email']").attr("disabled",false);
				$("input[name='phone']").attr("disabled",false);
				$("input[name='Address_detail']").attr("disabled",false);
				$('#download_create_tax').val('등록');
				openDialog("세금계산서 신청하기 <span class='desc'>세금계산서를 수동신청합니다.</span>", "tax_layer", {"width":"500","height":"670"});
<?php }?>
				});

				$("#cuse0").click(function(){
					$("#personallay").show();
					$("#businesslay").hide();
				});
				$("#cuse1").click(function(){
					$("#personallay").hide();
					$("#businesslay").show();
				});

				// 과세/비과세
				$("input[name='vat_type']", $("form[name='taxform']")).click(function() {
					calculatePrice(2);
				});
				$("#amount2").blur(function() {
					calculatePrice(2);
				});
				// 과세/비과세
				$("input[name='vat_type']", $("form[name='cashreceiptform']")).click(function() {
					calculatePrice(1);
				});
				$("#amount").blur(function() {
					calculatePrice(1);
				});

				$("input[name='tax_view']").click(function(){
					var seq = $(this).attr('seq');
					$.ajax({
						'url' : '../order/order_tax_info',
						'data' : {'seq':seq},
						'type' : 'post',
						'dataType' : 'json',
						'success' : function(data) {
							if(data.result) {
								if	(data.tstep == 1 && data.seq > 0){
									$frm	= $('form[name="taxform"]');
									$('input[name="mode"]', $frm).val('mod');
									$('input[name="seq"]', $frm).val(data.seq);
									$('#tstep_tax').html(data.tax_tstep);
									$('input[name="order_seq"]', $frm).val(data.order_seq);
									$('input[name="amount"]', $frm).val(data.price);
									$('input[name="supply"]', $frm).val(data.supply);
									$('input[name="surtax"]', $frm).val(data.surtax);
									$('#supplylay2').val(data.supply);
									$('#surtaxlay2').val(data.surtax);
									if	(data.vat_type == 2){
										document.taxform.vat_type[1].checked	= true;
									}else{
										document.taxform.vat_type[0].checked	= true;
									}

									if(data.type == 1){
										$('#tax_gubun').show();
										$('input[name="order_seq"]', $frm).css("display", "block");
										$('#order_seq_tax').html(data.order_seq);
										$('#order_seq_tax').show();
										$('.has_order').hide();
										$('input[name="amount"]', $frm).attr("readOnly", false);

									}else{
										$("#tax_gubun").hide();
										$('#order_seq_tax').html(data.order_seq);
										$('#order_seq_tax').show();
										$('.has_order').hide();
										$('input[name="amount"]', $frm).attr("readOnly", true);
									}

									$('input[name="co_name"]', $frm).val(data.co_name);
									$('input[name="busi_no"]', $frm).val(data.busi_no);
									$('input[name="co_ceo"]', $frm).val(data.co_ceo);
									$('input[name="co_status"]', $frm).val(data.co_status);
									$('input[name="co_type"]', $frm).val(data.co_type);
									$('input[name="Post_number"]', $frm).val(data.post_number);
									$('input[name="Zipcode[]"]', $frm).eq(0).val(data.zipcode);
									$('input[name="Address"]', $frm).val(data.address);
									$('input[name="Address_street"]', $frm).val(data.address_street);
									$('input[name="Address_detail"]', $frm).val(data.address_detail);
									$('input[name="person"]', $frm).val(data.person);
									$('input[name="email"]', $frm).val(data.email);
									$('input[name="phone"]', $frm).val(data.phone);
									$('#download_create_tax').val('수정');

									// 개인정보 마스킹 처리 입력폼 비활성화
<?php if($TPL_VAR["private_masking"]){?>
									$("input[name='co_ceo']").attr("disabled",true);
									$("input[name='person']").attr("disabled",true);
									$("input[name='email']").attr("disabled",true);
									$("input[name='phone']").attr("disabled",true);
									$("input[name='Address_detail']").attr("disabled",true);
<?php }?>

										openDialog("세금계산서 신청하기 <span class='desc'>세금계산서를 수동신청합니다.</span>", "tax_layer", {"width":"500","height":"670"});
									}else{
										if(data.vat_type == '1'){
											var vat_type = "세금계산서";
										}else{
											var vat_type = "일반계산서";
										}
										$('#vat_msg').html(vat_type);
										$('#tax_tstep').html(data.tax_tstep);
										$('#tax_order_seq').html(data.order_seq);
										$('#co_name').html(data.co_name);
										$('#co_ceo').html(data.co_ceo);
										$('#co_status').html(data.co_status);
										$('#co_type').html(data.co_type);
										$('#busi_no').html(data.busi_no);
										$('#tax_person').html(data.person);
										$('#tax_email').html(data.email);
										$('#tax_phone').html(data.phone);
										if(data.address_type == "street"){
											var address_data = "["+data.zipcode+"]<br><b>(도로명)</b> "+data.address_street+"<br> (지번) "+data.address;
											if(data.address_detail){
												address_data += "<br> (공통상세) "+data.address_detail;
											}
											$('#address').html(address_data);
										}else{
											var address_data = "["+data.zipcode+"]<br>(도로명) "+data.address_street+"<br> <b>(지번)</b> "+data.address;
											if(data.address_detail){
												address_data += "<br> (공통상세) "+data.address_detail;
											}
											$('#address').html(address_data);

										}
										$('#tax_price').html(data.view_price);
										$('#tax_supplylay').html(data.view_supply);
										$('#tax_surtaxlay').html(data.view_surtax);

										openDialog("세금계산서 <span class='desc'>신청내역 상세정보입니다.</span>", "taxlay", {"width":"500","height":"600"});
									}
								}
							}
						});
				});

					$("input[name='cash_view']").click(function(){
						var order_seq	= $(this).attr('order_seq');
						var seq			= $(this).attr('seq');
						$.ajax({
							'url' : '../order/order_cash_info',
							'data' : {'order_seq':order_seq,'seq':seq},
							'type' : 'post',
							'dataType' : 'json',
							'success' : function(data) {
								$('.cash_phone').show();
								// 자진발급 시 휴대폰 정보 숨김
								if(data.type=='3') {
									$('.cash_phone').hide();
								}
								if(data.result) {
									if	(data.tstep == 1 && data.seq > 0){
										$frm	= $('form[name="cashreceiptform"]');
										$('input[name="mode"]', $frm).val('mod');
										$('input[name="seq"]', $frm).val(data.seq);
										$('input[name="order_date"]', $frm).val(data.odates);
										if	(data.surtax > 0){
											var vat_type_label = "과세";
											document.cashreceiptform.vat_type[1].checked	= true;
										}else{
											var vat_type_label = "비과세";
											document.cashreceiptform.vat_type[0].checked	= true;
										}

										if(data.type == 1){
											$(".vat_type_label").show();
											$(".order_date").show();
											$("#vat_type_cash").html("");
											$('input[name="order_date"]', $frm).show();
											$('input[name="goodsname"]', $frm).show();
											$('#order_date_cash').html("");
											$('#goodsname_cash').html("");
											$('input[name="amount"]', $frm).attr("readOnly", false);
										}else{
											$(".vat_type_label").hide();
											$("#vat_type_cash").html(vat_type_label);

											$('input[name="order_date"]', $frm).hide();
											$('input[name="goodsname"]', $frm).hide();
											$('#order_date_cash').html(data.order_date);
											$('#goodsname_cash').html(data.goodsname);
											$('input[name="amount"]', $frm).attr("readOnly", true);
										}

										if	(data.cuse == "사업자지출 증빙용"){
											$('#personallay').hide();
											$('#businesslay').show();
											document.cashreceiptform.cuse[1].checked	= true;
											$('input[name="creceipt_number[1]"]', $frm).val(data.creceipt_number);
										}else{
											$('#personallay').show();
											$('#businesslay').hide();
											document.cashreceiptform.cuse[0].checked	= true;
											$('input[name="creceipt_number[0]"]', $frm).val(data.creceipt_number);
										}

										if	(data.order_seq){
											$('.selected_order_seq',$frm).val(data.order_seq);
											$('.selected_order_seq_txt',$frm).html(data.order_seq);
											$('.selected_order_seq_txt').show();
											$('.has_order').hide();
										}
										$('input[name="name"]', $frm).val(data.person);
										$('input[name="email"]', $frm).val(data.email);
										$('input[name="phone"]', $frm).val(data.phone);
										$('input[name="goodsname"]', $frm).val(data.goodsname);
										$('input[name="amount"]', $frm).val(data.price);
										$('input[name="supply"]', $frm).val(data.supply);
										$('input[name="surtax"]', $frm).val(data.surtax);
										$('#supplylay').val(data.supply);
										$('#surtaxlay').val(data.surtax);
										$('#download_create_cash').val('수정');

										// 개인정보 마스킹 처리 입력폼 비활성화
<?php if($TPL_VAR["private_masking"]){?>
										$("input[name='name']").attr("disabled",true);
										$("input[name='email']").attr("disabled",true);
										$("input[name='phone']").attr("disabled",true);
										$("input[name='creceipt_number[0]']").attr("disabled",true);
<?php }?>

											openDialog("현금영수증 수동발급 <span class='desc'>현금영수증을 수동발급합니다.</span>", "cashreceiptlay", {"width":"500","height":"500"});

										}else{
											$('#cash_order_date').html(data.order_date);
											$('#cuse').html(data.cuse);
											$('#person').html(data.person);
											$('#email').html(data.email);
											$('#phone').html(data.phone);
											$('#goodsname').html(data.goodsname);
											$('#price').html(data.view_price);
											$('#supply').html(data.view_supply);
											$('#surtax').html(data.view_surtax);
											$('#cash_order_seq').html(data.order_seq);
											$('#cash_msg').html(data.cash_msg);
											$('#r_creceipt_number').html(data.creceipt_number);
											openDialog("현금영수증 <span class='desc'>신청내역 상세정보입니다.</span>", "cash_lay", {"width":"500","height":"420"});
										}
									}
								}
							});
					});

						$("input[name='link_btn']").click(function(){
							var pgset		= "<?php echo $TPL_VAR["pg"]["pgSet"]?>";
							var hiworks		= "<?php echo $TPL_VAR["webmail_admin_id"]?>";
							var typereceipt	= $(this).attr("typereceipt");
							var step		= $(this).attr("step");
							var seq			= $(this).attr("seq");
							var order_seq	= $(this).attr("order_seq");

							if	(confirm("매출 증빙 자료를  PG 나 하이웍스로 수동으로  전송합니다.  결제여부와 상관 없이 전송되므로 주의하시길 바랍니다.\n\n(고객이 신청한 경우에는 입금확인시 자동으로 전송이 됩니다.)")){
								if	(typereceipt == '1'){
									if	(hiworks){
										$.ajax({
											'url' : '../sales_process/tax_check',
											'data' : {'sales_log':'y','seq':seq},
											'type' : 'post',
											'dataType': 'json',
											'success' : function(data) {
												if(data.result === true) {
													alert(data.msg);
												}else{
													alert(data.msg);
												}
												document.location.reload();
											}
										});
									}else{
										alert("하이웍스 설정값이 없습니다.\n설정> 매출증빙에서 하이웍스를 설정해 주세요");
									}
								}else if (typereceipt == '2'){
									if	(pgset == 'ok'){
										$.ajax({
											type: "get",
											url: "../order_process/receipt_process",
											data: "sales_log=y&order_seq="+order_seq+"&seq="+seq,
											dataType: 'json',
											success: function(result){
												if	(result.result == true){
													alert("처리되었습니다.");
												}else{
													alert("PG 나 하이웍스에서 응답이 없습니다.\n일시적인 장애가 있을 수 있으니 잠시 후에 다시 시도 해 주세요.\n\n(계속적으로 발생하면 퍼스트몰 고객센터로 문의하시길 바랍니다.)");
												}
												document.location.reload();
											}
										});
									}else{
										alert("PG 설정값이 없습니다.\n설정> 전자결제에서 PG를 설정해 주세요");
									}
								}
							}
						});

						$("input[name='unlink_btn']").click(function(){
							var step		= $(this).attr("step");
							var seq			= $(this).attr("seq");
							var order_seq	= $(this).attr("order_seq");

							if(confirm("매출 증빙 자료를 미연동 처리합니다.\nPG나 하이웍스를 이용하지 않고 별도로 발행을 하는 경우로.\n구매자에게 마이페이지에서 내역을 확인 할 수 없습니다.")){
								actionFrame.location.href = "../sales_process/sales_unlink?seq="+seq;
							}
						});

						$("input[name='cancel_btn']").click(function(){
							var step		= $(this).attr("step");
							var seq			= $(this).attr("seq");
							var order_seq	= $(this).attr("order_seq");

							if(confirm("매출 증빙 신청을 취소합니다.")){
								actionFrame.location.href = "../sales_process/sales_cancel?seq="+seq+"&order_seq="+order_seq;
							}
						});

						$('#display_quantity').bind('change', function() {
							$.cookie( "itemlist_qty", $(this).val() );
							$("#perpage").val($(this).val());
							$("#fromsearch").submit();
						});

						//체크박스 색상
						$("input[type='checkbox'][name='del[]']").live('change',function(){
							if($(this).is(':checked')){
								$(this).closest('tr').addClass('checked-tr-background');
							}else{
								$(this).closest('tr').removeClass('checked-tr-background');
							}
						}).change();

						$("#zipcodeButton").live("click",function(){
<?php if($TPL_VAR["private_masking"]){?>
							openDialogAlert("권한이 없습니다.",400,150,function(){});
<?php }else{?>
							openDialogZipcode('');
<?php }?>
							});

							//매출전표처리
							$("button[name='pgreceiptbtn']").click(function(){
								var tno= $(this).attr('tno');
								var shopid= '<?php echo $TPL_VAR["pg"]["mallCode"]?>';
								var ordno= $(this).attr('order_seq');
								var authdata= $(this).attr('authdata');
								var pg_kind = $(this).attr('pg_kind');
								var payment = $(this).attr('payment');
								receiptView(tno, shopid, ordno, pg_kind, authdata, payment);
							});

							//현금영수증처리
							$("button[name='pgcashbtn2']").click(function(){
								var cash_no= $(this).attr('cash_receipts_no');
								var shopid= '<?php echo $TPL_VAR["pg"]["mallCode"]?>';
								var ordno= $(this).attr('order_seq');
								var settleprice= $(this).attr('settleprice');
								var pg_kind= $(this).attr('pg_kind');
								var  tax_bank = '';
								var cst_platform = '';
								if(pg_kind){
									if(pg_kind=="lg"){
										$.ajax({
											'url' : '../order/order_pg_info',
											'data' : {'order_seq':ordno},
											'type' : 'post',
											'dataType' : 'json',
											'success' : function(data) {
												if(data.result) {
													var  tax_bank = data.tax_bank;
													var cst_platform = data.cst_platform;
													cashView(cash_no, shopid, ordno, settleprice, tax_bank, cst_platform, pg_kind);
												}
											}
										});
									}else{
										var  tax_bank		= '';
										var cst_platform	= '';
										cashView(cash_no, shopid, ordno, settleprice, tax_bank, cst_platform, pg_kind);
									}
								}else{
<?php if($TPL_VAR["config_system"]["pgCompany"]=='lg'){?>
									$.ajax({
										'url' : '../order/order_pg_info',
										'data' : {'order_seq':ordno},
										'type' : 'post',
										'dataType' : 'json',
										'success' : function(data) {
											if(data.result) {
												var  tax_bank = data.tax_bank;
												var cst_platform = data.cst_platform;
												cashView(cash_no, shopid, ordno, settleprice, tax_bank, cst_platform);
											}
										}
									});
<?php }else{?>
									var  tax_bank		= '';
									var cst_platform	= '';
									cashView(cash_no, shopid, ordno, settleprice, tax_bank, cst_platform);
<?php }?>
									}
								});


								$('#download_create_cash').bind('click', function(){
<?php if($TPL_VAR["private_masking"]){?>
									openDialogAlert("권한이 없습니다.",400,150,function(){});
<?php }else{?>
									var frm			= $('form[name="cashreceiptform"]');
									var url			= frm.attr('action');
									var	form_data	= frm.serialize();

									$('#download_create_cash').attr('disabled', true);
									$.post(url, form_data, function(data){
										$("iframe[name=actionFrame")[0].contentWindow.document.write(data);
									}).done(function(){
										$('#download_create_cash').attr('disabled', false);
									});
<?php }?>
									});


									$('#download_create_tax').bind('click', function(){
<?php if($TPL_VAR["private_masking"]){?>
										openDialogAlert("권한이 없습니다.",400,150,function(){});
<?php }else{?>
										var frm			= $('form[name="taxform"]');
										var url			= frm.attr('action');
										var	form_data	= frm.serialize();

										$('#download_create_tax').attr('disabled', true);
										$.post(url, form_data, function(data){
											$("iframe[name=actionFrame")[0].contentWindow.document.write(data);
										}).done(function(){
											$('#download_create_tax').attr('disabled', false);
										});
<?php }?>
										});

									});

									function sales_memo(seq, order_seq){
										$("input[name='sales_seq']").val(seq);
										$("input[name='order_seq']").val(order_seq);
										$("#memo_order_seq").html('<a href="view?no='+order_seq+'" target="_blank"><span class="blue bold">'+order_seq+'</span></a>');
										$.ajax({
											'url' : '../sales_process/sales_memo',
											'data' : {'seq':seq},
											'type' : 'get',
											'dataType': 'json',
											'success' : function(data) {
												if(data.memo){
													$("#btn_td").val("수정");
												}else{
													$("#btn_td").val("등록");
												}
												$("#sales_memo").val(data.memo);
												openDialog("관리자 메모 <span class='desc'></span>", "memo_layer", {"width":"700","height":"400"});
											}
										});
									}

									function tax_send_log(seq){
										$.ajax({
											'url' : '../sales_process/tax_send_log',
											'data' : {'seq':seq},
											'type' : 'post',
											'dataType': 'json',
											'success' : function(data) {
												if(data.result && data.count > 0) {
													var log_html	= '<table class="log_table" cellpadding="0" cellspacing="0">';
													for	(z = 0; z < data.count; z++){
														log_html	+= '<tr>';
														log_html	+= '<td class="log_date">'+data[z].reg_date+'</td>';
														log_html	+= '<td class="log_msg">'+data[z].log_msg+'</td>';
														log_html	+= '</tr>';
													}
													log_html	+= '</table>';
													$("#tax_send_log").html(log_html);
													openDialog("전송로그 <span class='desc'></span>", "tax_send_log", {"width":"500","height":"350"});
												}else{
													alert('전송로그가 없습니다.');
												}
											}
										});
									}

									function guidefail(){
										openDialog("연동처리 실패건 안내", "guidefail", {"width":"600","height":"180"});
									}

									/**
									 * 체크박스 전체 선택
									 * @param string el 전체 선택 체크박스
									 * @param string targetEl 적용될 체크박스 클래스명
									 */
									function checkAll(el, targetEl) {
										if( $(el).attr('rel') == 'yes' ) {
											var do_check = false;
											$(el).attr('rel', 'no');
										} else {
											var do_check = true;
											$(el).attr('rel', 'yes');
										}
										$(targetEl).each(function(e, el) {
											if( $(el).attr('disabled') != 'disabled' ){//제외
												$(el).attr('checked', do_check);
												if(do_check == true){
													$(el).parent().parent().find('td').addClass('bg-silver');//.removeClass('bg-silver');
												}else{
													$(el).parent().parent().find('td').removeClass('bg-silver');
												}
											}else{
												$(el).parent().parent().find('td').removeClass('bg-silver');
											}
										});
									}

									function calculatePrice(type){
										var form_name		= 'cashreceiptform';
										var price_id		= '#amount';
										var suppliy_id		= '#supply1';
										var surtax_id		= '#surtax1';
										var supplylay_id	= '#supplylay';
										var surtaxlay_id	= '#surtaxlay';
										if	(type == 2){
											form_name		= 'taxform';
											price_id		= '#amount2';
											suppliy_id		= '#supply2';
											surtax_id		= '#surtax2';
											supplylay_id	= '#supplylay2';
											surtaxlay_id	= '#surtaxlay2';
										}

										var tprice		= $(price_id).val();
										var supply		= '';
										var surtax		= '';
										var vat_type	= $("input[name='vat_type']:checked", $("form[name='"+form_name+"']")).val();
										if	(tprice > 0){
											if	(vat_type == 2)	supply	= tprice;
											else				supply	= Math.round(tprice*(10/11));
											surtax	= tprice - supply;
										}

										$(suppliy_id).val(supply);
										$(surtax_id).val(surtax);
										$(supplylay_id).val(supply);
										$(surtaxlay_id).val(surtax);
									}

									//매출전표 처리
									function receiptView(tno, shopid, ordno, pg_kind, authdata, payment)
									{
										if(pg_kind){
											if(pg_kind=='kcp'){
												if(payment == "cellphone"){
													receiptWin = "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=mcash_bill&h_trade_no=" + tno;
												}else if(payment == "virtual"){
													receiptWin = "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=vcnt_bill&a_trade_no=" + tno;
												}else if(payment == "account"){
													receiptWin = "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=acnt_bill&h_trade_no=" + tno;
												}else{
													receiptWin = "https://admin.kcp.co.kr/Modules/Sale/Card/ADSA_CARD_BILL_Receipt.jsp?c_trade_no=" + tno;
												}
												window.open(receiptWin , "" , "width=450, height=800, scrollbars=yes");
											}else if(pg_kind=='inicis'){
												receiptWin = "https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid="+ tno + "&noMethod=1";
												window.open(receiptWin , "" , "width=410,height=715, scrollbars=no,resizable=no");
											}else if(pg_kind=='lg'){
												showReceiptByTID(shopid, tno, authdata);
											}else if(pg_kind=='allat'){
												if(payment == "cellphone"){
													var allat_urls = "https://www.allatpay.com/servlet/AllatBizPop/member/pop_tx_receipt.jsp?tx_seq_no="+tno+"&order_no="+ordno+"&pay_type=HP";
													window.open(allat_urls,"app","width=410,height=650,scrollbars=0");
												}else{
													var allat_urls = "https://www.allatpay.com/servlet/AllatBizPop/member/pop_card_receipt.jsp?tx_seq_no="+tno+"&order_no="+ordno;
													window.open(allat_urls,"app","width=410,height=650,scrollbars=0");
												}
											}else if(pg_kind=='kspay'){
												var allat_urls = "https://nims.ksnet.co.kr/pg_infoc/src/bill/credit_view_print.jsp?tr_no="+tno;
												window.open(allat_urls,"app","width=456,height=700,scrollbars=1");
											}else if(pg_kind=='kakaopay'){
												var status = "toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=550,height=540";
												$.get('/kakaopay/pg_confirm?no='+ordno+'&tno='+tno, function(data) {
													var url = data;
													window.open(url,"popupIssue",status);
												});
											}else if(pg_kind=='kicc'){
												var status = "toolbar=0,scroll=1,menubar=0,status=0,resizable=0,width=380,height=700";
												$.get('/kicc/receipt?no='+ordno, function(data) {
													var url = data;
													if(url!='false'){
														window.open(url,"popupIssue",status);
													}else{
														alert('매출증빙 요청 정보가 올바르지 않습니다.');
													}
												});
											}else if(pg_kind=='payco'){
												var status = "toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=550,height=540";
												$.get('/payco/pg_confirm?no='+ordno+'&admin=1', function(data) {
													var url = data;
													window.open(url,"popupIssue",status);
												});
											}
										}else{
<?php if($TPL_VAR["config_system"]["pgCompany"]=='kcp'){?>
											if(payment == "cellphone"){
												receiptWin = "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=mcash_bill&h_trade_no=" + tno;
											}else if(payment == "virtual"){
												receiptWin = "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=vcnt_bill&a_trade_no=" + tno;
											}else if(payment == "account"){
												receiptWin = "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=acnt_bill&h_trade_no=" + tno;
											}else{
												receiptWin = "https://admin.kcp.co.kr/Modules/Sale/Card/ADSA_CARD_BILL_Receipt.jsp?c_trade_no=" + tno;
											}
											window.open(receiptWin , "" , "width=450, height=800, scrollbars=yes");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='inicis'){?>
											receiptWin = "https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid="+ tno + "&noMethod=1";
											window.open(receiptWin , "" , "width=410,height=715, scrollbars=no,resizable=no");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='lg'){?>
											showReceiptByTID(shopid, tno, authdata);
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='allat'){?>
											if(payment == "cellphone"){
												var allat_urls = "https://www.allatpay.com/servlet/AllatBizPop/member/pop_tx_receipt.jsp?tx_seq_no="+tno+"&order_no="+ordno+"&pay_type=HP";
												window.open(allat_urls,"app","width=410,height=650,scrollbars=0");
											}else{
												var allat_urls = "https://www.allatpay.com/servlet/AllatBizPop/member/pop_card_receipt.jsp?tx_seq_no="+tno+"&order_no="+ordno;
												window.open(allat_urls,"app","width=410,height=650,scrollbars=0");
											}
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='kspay'){?>
											var allat_urls = "https://nims.ksnet.co.kr/pg_infoc/src/bill/credit_view_print.jsp?tr_no="+tno;
											window.open(allat_urls,"app","width=456,height=700,scrollbars=1");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='kicc'){?>
											var status = "toolbar=0,scroll=1,menubar=0,status=0,resizable=0,width=380,height=700";
											$.get('/kicc/receipt?no='+ordno, function(data) {
												var url = data;
												if(url!='false'){
													window.open(url,"popupIssue",status);
												}else{
													alert('매출증빙 요청 정보가 올바르지 않습니다.');
												}
											});
<?php }?>
											}
										}

										//현금영수증처리
										function cashView(cash_no, shopid, ordno, settleprice, tax_bank, cst_platform, pg_kind)
										{
											if(pg_kind){
												if(pg_kind=="kcp"){
													receiptWin = receiptWin = "https://admin.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp?cash_no="+cash_no;
													window.open(receiptWin , "" , "width=360, height=647");
												}else if(pg_kind=="inicis"){
													showreceiptUrl = "https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/Cash_mCmReceipt.jsp?noTid="+ cash_no + "&clpaymethod=22";
													window.open(showreceiptUrl,"showreceipt","width=380,height=540, scrollbars=no,resizable=no");
												}else if(pg_kind=="lg"){
													showCashReceipts(shopid, ordno, '01', tax_bank, cst_platform);
												}else if(pg_kind=="allat"){
													var cash_no = cash_no.replace( /(^\s*)|(\s*$)/g, "" );
													var urls ="https://www.allatpay.com/servlet/AllatBizPop/member/pop_cash_receipt.jsp?receipt_seq_no="+ cash_no + "&shop_id="+shopid+"&amt="+settleprice;
													window.open(urls,"app","width=410,height=650,scrollbars=0");
												}else if(pg_kind=="kspay"){
													showreceiptUrl = "https://nims.ksnet.co.kr/pg_infoc/src/bill/ps2.jsp?s_pg_deal_numb="+cash_no;
													window.open(showreceiptUrl ,"showreceipt","width=435, height=540");
												}else if(pg_kind=='kicc'){
													var status = "toolbar=0,scroll=1,menubar=0,status=0,resizable=0,width=380,height=700";
													$.get('/kicc/receipt?no='+ordno, function(data) {
														var url = data;
														if(url!='false'){
															window.open(url,"popupIssue",status);
														}else{
															alert('매출증빙 요청 정보가 올바르지 않습니다.');
														}
													});
												}
											}else{
<?php if($TPL_VAR["config_system"]["pgCompany"]==="kcp"){?>
												receiptWin = receiptWin = "https://admin.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp?cash_no="+cash_no;
												window.open(receiptWin , "" , "width=360, height=647");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]==="inicis"){?>
												showreceiptUrl = "https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/Cash_mCmReceipt.jsp?noTid="+ cash_no + "&clpaymethod=22";
												window.open(showreceiptUrl,"showreceipt","width=380,height=540, scrollbars=no,resizable=no");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='lg'){?>
												showCashReceipts(shopid, ordno, '01', tax_bank, cst_platform);
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='allat'){?>
												var cash_no = cash_no.replace( /(^\s*)|(\s*$)/g, "" );
												var urls ="https://www.allatpay.com/servlet/AllatBizPop/member/pop_cash_receipt.jsp?receipt_seq_no="+ cash_no + "&shop_id="+shopid+"&amt="+settleprice;
												window.open(urls,"app","width=410,height=650,scrollbars=0");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='kspay'){?>
												showreceiptUrl = "https://nims.ksnet.co.kr/pg_infoc/src/bill/ps2.jsp?s_pg_deal_numb="+cash_no;
												window.open(showreceiptUrl ,"showreceipt","width=435, height=540");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='kicc'){?>
												var status = "toolbar=0,scroll=1,menubar=0,status=0,resizable=0,width=380,height=700";
												$.get('/kicc/receipt?no='+ordno, function(data) {
													var url = data;
													if(url!='false'){
														window.open(url,"popupIssue",status);
													}else{
														alert('매출증빙 요청 정보가 올바르지 않습니다.');
													}
												});
<?php }?>
												}
											}

											function sales_all_down(kind){
												sales_seq = new Array();
												sale_seq = '';
												chk_select = '';
												if(kind == 'chk'){
													x = 0;
													$('.checkeds').each(function(e, el) {
														if( $(el).attr('checked') == 'checked'){
															sales_seq[x] = $(el).val();
															x++;
														}
													});
													sale_seq = sales_seq.join(',');
													chk_select = 'select';
													if(!sale_seq){
														alert('선택값이 없습니다.');
														return;
													}
												}
												$("form[name='fromsearch']").find("input[name='salesSeq']").val(sale_seq);
												$("form[name='fromsearch']").find("input[name='searchSelect']").val(chk_select);
												$("form[name='fromsearch']").attr('action', '../sales_process/sales_excel_download');
												$("form[name='fromsearch']").attr('target', 'actionFrame');
												$("form[name='fromsearch']").submit();
												$("form[name='fromsearch']").attr('action', '../order/sales');
												$("form[name='fromsearch']").attr('target', '');
												$("form[name='fromsearch']").find("input[name='salesSeq']").val('');
												$("form[name='fromsearch']").find("input[name='searchSelect']").val('');
											}

											// 주문번호 검색 :: 2017-08-28 lwh
											function order_search(search_kind){
												if(search_kind != '') {
													url			= '../order/order_search_popup?return_func=select_order&voucher_type=' + search_kind;
												} else {
													url			= '../order/order_search_popup?return_func=select_order';
												}
												search_pop	= window.open(url,'order_search_pop','width=1000,height=700,scrollbars=1,toolbar=0,status=0,resizable=0,menubar=0');
											}

											// 주문번호 받아오기 :: 2017-08-28 lwh
											function selected_order_seq(order_seq){

												// 주문번호 유효성 검사
												var params			= {};
												params.order_seq	= order_seq;
												$.get('../sales_process/ajax_sales_list',params, function(response){
													if(response > 0){
														alert('이미 매출증빙이 신청된 주문서 입니다.');
														return false;
													}else{
														params.goods_name	= '1';
														params.order_price	= '1';
														search_pop.close();
														$(".selected_order_seq").val(order_seq);
														$(".selected_order_seq_txt").html(order_seq);
														$(".selected_order_seq_txt").show();

														$.get('../order/get_order_info',params, function(response){
															var orderObj	= response.order_info;
															var phone		= orderObj.order_phone_num;

															$("input[name='name']").val(orderObj.order_user_name);
															$("input[name='order_date']").val(orderObj.deposit_date);

															if(orderObj.order_cellphone_num) phone = orderObj.order_cellphone_num;
															$("input[name='phone']").val(phone);
															$("input[name='goodsname']").val(orderObj.goods_name);

															if(!response.tax_price.surtax && !response.tax_price.supply){
																response.tax_price.supply = response.tax_price.supply_free;
																response.tax_price.surtax = 0;
																$('input[name="vat_type"]:radio[value="2"]').prop('checked',true);
															}else{
																$('input[name="vat_type"]:radio[value="1"]').prop('checked',true);
															}

															$("input[name='amount']").val(response.tax_price.total_price);
															$("input[name='supply']").val(response.tax_price.supply);
															$("input[name='surtax']").val(response.tax_price.surtax);
															$("#supplylay").val(response.tax_price.supply);
															$("#supplylay2").val(response.tax_price.supply);
															$("#surtaxlay").val(response.tax_price.surtax);
															$("#surtaxlay2").val(response.tax_price.surtax);
														},'json');
													}
												});
											}
</script>
<!-- 2022.01.04 11월 4차 패치 by 김혜진 -->
<script type="text/javascript" src="/app/javascript/js/admin-searchForm.js?v=<?php echo date('Ymd')?>"></script>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/searchform.css" />
<style type="text/css">
	.search_label 	{display:inline-block;width:80px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	.log_table	{width:100%;border:1px solid #535353;}
	.log_date	{width:150px;text-align:center;height:22px; border-top:1px solid #535353;border-right:1px solid #535353;}
	.log_msg	{text-align:left;padding-left:10px;border-top:1px solid #535353;}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar"  >
		<!-- 좌측 버튼 -->

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>매출증빙 리스트</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><span class="btn large black"><button type="button" class="cashreceiptBtn">(수동) 현금영수증 신청<span class="arrowright"></span></button></span></li>

			<li><span class="btn large black"><button type="button" id="taxBtn">(수동) 세금계산서 신청<span class="arrowright"></span></button></span></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<!-- 리스트검색폼 : 시작 -->
<div class="search-form-container">
	<form name="fromsearch" id="fromsearch">
		<input type="hidden" name="perpage" id="perpage" value="<?php echo $_GET["perpage"]?>" >
		<input type="hidden" name="salesSeq" id="salesSeq'" value="" />
		<input type="hidden" name="searchSelect" id="searchSelect" value="" />
		<table class="table_search">
			<tr>
				<th>검색어</th>
				<td>
					<input type="text" name="keyword" value="<?php echo $_GET["keyword"]?>" size="100" title="주문자, 주문번호, 담당자" />
</div>
</td>
</tr>
</table>

<div class="search-detail-lay">
	<table class="search-form-table" id="search_detail_table">
		<tr>
			<td>
				<table class="sf-option-table table_search">
					<tr>
						<th>날짜</th>
						<td>
							<select name="date_gb" class="search_select" style="width:100px" default_none>
								<option value="all" <?php if($TPL_VAR["sc"]["date_gb"]=='all'){?>selected<?php }?>>신청/주문일</option>
								<option value="order_date" <?php if($TPL_VAR["sc"]["date_gb"]=='order_date'){?>selected<?php }?>>주문일</option>
								<option value="regdate" <?php if($TPL_VAR["sc"]["date_gb"]=='regdate'){?>selected<?php }?>>신청일</option>
								<option value="up_date" <?php if($TPL_VAR["sc"]["date_gb"]=='up_date'){?>selected<?php }?>>처리확정일</option>
							</select>

							<input type="text" name="sdate" id="sdate" value="<?php echo $_GET["sdate"]?>" class="datepicker"  maxlength="10" style="width:80px" default_none />
							&nbsp;<span class="gray">-</span>&nbsp;
							<input type="text" name="edate" id="edate" value="<?php echo $_GET["edate"]?>" class="datepicker" maxlength="10" style="width:80px" default_none />
							<span class="resp_btn_wrap">
									<span class="btn small"><input type="button" id="today" value="오늘" class="select_date resp_btn" /></span>
									<span class="btn small"><input type="button" id="3day" value="3일간" class="select_date resp_btn" /></span>
									<span class="btn small"><input type="button" id="1week" value="일주일" class="select_date resp_btn" /></span>
									<span class="btn small"><input type="button" id="1month" value="1개월" class="select_date resp_btn" /></span>
									<span class="btn small"><input type="button" id="3month" value="3개월" class="select_date resp_btn" /></span>
									<span class="btn small"><input type="button" id="all" value="전체" class="select_date resp_btn"  /></span>
								</span>
						</td>
					</tr>
				</table>
				<table class="sf-option-table table_search">
					<col width="70"><col width="365">
					<col width="70"><col>
					<tr>
						<th>증빙서류</th>
						<td no=0>
							<div class="resp_checkbox">
								<label><input type="checkbox" name="typereceipt[]" id="typereceipt0" value="0" <?php echo $TPL_VAR["checked"]["typereceipt"][ 0]?> /> 매출전표</label>
								<label><input type="checkbox" name="typereceipt[]" id="typereceipt1" value="1" <?php echo $TPL_VAR["checked"]["typereceipt"][ 1]?> /> 세금계산서</label>
								<label><input type="checkbox" name="typereceipt[]" id="typereceipt2" value="2" <?php echo $TPL_VAR["checked"]["typereceipt"][ 2]?> /> 현금영수증</label>
							</div>
						</td>
						<th>신청구분</th>
						<td no=1>
							<!-- 0: 주문시, 1: 관리자수동발급, 2: 주문자마이페이지에서발급, 3: 자진발급 -->
							<div class="resp_checkbox">
								<label><input type="checkbox" name="admin_type[]" value="0,2" <?php echo $TPL_VAR["checked"]["admin_type"]['0,2']?> default_none /> 구매자</label>
								<label><input type="checkbox" name="admin_type[]" value="1" <?php echo $TPL_VAR["checked"]["admin_type"]['1']?> default_none /> 관리자</label>
								<label><input type="checkbox" name="admin_type[]" value="3" <?php echo $TPL_VAR["checked"]["admin_type"]['3']?> default_none /> 자진 발급</label>
							</div>
						</td>
					</tr>
					<tr>
						<th>결제여부</th>
						<td no=0>
							<div class="resp_checkbox">
								<label><input type="checkbox" name="ostep[]" value="1" <?php echo $TPL_VAR["checked"]["ostep"][ 1]?> /> 입금</label>
								<label><input type="checkbox" name="ostep[]" value="2" <?php echo $TPL_VAR["checked"]["ostep"][ 2]?> /> 미입금</label>
							</div>
						</td>
						<th>환불유무</th>
						<td no=1>
							<div class="resp_checkbox">
								<label><input type="checkbox" name="orefund[]" value="1" <?php echo $TPL_VAR["checked"]["orefund"][ 1]?>/> 있음</label>
								<label><input type="checkbox" name="orefund[]" value="2" <?php echo $TPL_VAR["checked"]["orefund"][ 2]?>/> 없음</label>
							</div>
						</td>
					</tr>
					<tr>
						<th>상태</th>
						<td colspan="3">
							<div class="resp_checkbox">
								<label><input type="checkbox" name="tstep[]" value="1" <?php echo $TPL_VAR["checked"]["tstep"][ 1]?>/> 대기
									<span class="helpicon" title="고객이나 관리자가 매출 증빙 자료 신청을 한 상태입니다. 아직 발급전입니다."></span></label>
								<label><input type="checkbox" name="tstep[]" value="2" <?php echo $TPL_VAR["checked"]["tstep"][ 2]?>/> 완료(연동)
									<span class="helpicon" title="신청을 한 매출 증빙 자료가 연동한 PG 나 하이웍스를통해 정상적으로 발행 완료된 상태입니다."></span></label>
								<label><input type="checkbox" name="tstep[]" value="5" <?php echo $TPL_VAR["checked"]["tstep"][ 5]?>/> 완료(미연동)
									<span class="helpicon" title="매출 증빙 자료가 PG 나 하이웍스를 통하지 않고 처리를 한 상태이며 , 고객이 마이 페이지에서 확인할 수 없으므로 별도로 고객에게 자료를 전송하거나 알려줘야 합니다."></span></label>
								<label><input type="checkbox" name="tstep[]" value="3" <?php echo $TPL_VAR["checked"]["tstep"][ 3]?>/> 취소
									<span class="helpicon" title="매출 증빙 자료 신청을 취소한 상태입니다."></span></label>
								<label><input type="checkbox" name="tstep[]" value="4" <?php echo $TPL_VAR["checked"]["tstep"][ 4]?> /> 완료(연동실패)
									<span class="helpicon" title="연동처리 하였으나 연동이 실패하였습니다."></span></label>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table class="warning_mess" width="100%" style="text-align:center; color:#f00;">
		<tr>
			<td>
				! PG사로 전송되어 발행된 현금영수증에 대하여 구매자에게 돈을 되돌려주게 되는 경우(결제취소,반품/환불)가 발생하면 현금영수증 취소(전체 또는 부분) 처리는 PG사 관리자페이지에서 하십시오.<br>
				! 하이윅스로 전송된 전자세금계산서에 대하여 구매자에게 돈을 되돌려주게 되는 경우(결제취소,반품/환불)가 발생하면 마이너스(-) 전자세금계산서 처리는 하이윅스 관리자페이지에서 하십시오.
			</td>
		</tr>
	</table>
</div>

<div class="footer search_btn_lay">
	<div>
			<span class="sc_edit">
				<button type="button" id="set_default_setting_button" class="resp_btn v3">기본검색설정</button>
				<button type="button" id="set_default_apply_button" onclick="set_search_form('sales')" class="resp_btn v3">기본검색적용</button>
			</span>
		<span class="search">
				<button type="submit" class="resp_btn active size_XL"><span>검색</span></button>
				<button type="button" id="search_reset_button" class="resp_btn v3 size_XL">초기화</button>
			</span>
		<span class="detail">
				<button type="button" id="search_detail_button" class="close resp_btn v3" value="open">상세검색닫기</button>
			</span>
	</div>
</div>
</form>
</div>
<!-- 리스트검색폼 : 끝 -->

<div class="clearbox">
	<ul class="left-btns">
		<li><select class="custom-select-box-multi" id="multichkec" >
			<option value="true">전체선택</option>
			<option value="false">전체해제</option>
		</select>
		</li>
		<li>
			<span class="btn small"><input type="button" id="sales_multi_delete" value="삭제처리"/></span>
		</li>
		<li><div class="pdl5 left-btns-txt">검색 <b><?php echo number_format($TPL_VAR["sc"]["searchcount"])?></b>개</div></li>
	</ul>
	<ul class="right-btns">
		<li>
			<span class="btn small"><button name="excel_down" onclick="sales_all_down('chk')"><img align="absmiddle" src="/admin/skin/default/images/common/btn_img_ex.gif"> 일괄다운로드(선택)</button></span>
		</li>
		<li>
			<span class="btn small"><button name="excel_down" onclick="sales_all_down('all')"><img align="absmiddle" src="/admin/skin/default/images/common/btn_img_ex.gif"> 일괄다운로드(전체)</button></span>
		</li>
		<li>
			<select  class="custom-select-box-multi btn drop_multi_main " id="display_quantity">
				<option id="dp_qty10" value="10" <?php if($TPL_VAR["sc"]["perpage"]=='10'){?> selected <?php }?> >10개씩</option>
				<option id="dp_qty20" value="20" <?php if($TPL_VAR["sc"]["perpage"]=='20'){?> selected<?php }?> >20개씩</option>
				<option id="dp_qty30" value="30" <?php if($TPL_VAR["sc"]["perpage"]=='30'){?> selected<?php }?> >30개씩</option>
				<option id="dp_qty50" value="50" <?php if($TPL_VAR["sc"]["perpage"]=='50'){?> selected<?php }?> >50개씩</option>
				<option id="dp_qty50" value="100" <?php if($TPL_VAR["sc"]["perpage"]=='100'){?> selected<?php }?> >100개씩</option>
				<option id="dp_qty50" value="150" <?php if($TPL_VAR["sc"]["perpage"]=='150'){?> selected<?php }?> >150개씩</option>
				<option id="dp_qty50" value="200" <?php if($TPL_VAR["sc"]["perpage"]=='200'){?> selected<?php }?> >200개씩</option>
			</select>
		</li>
	</ul>
</div>

<div class="clearbox">
	<table class="info-table-style" style="width:100%">
		<!--colgroup>
			<col width="2%" />
			<col width="3%" />
			<col width="3%" />
			<col width="14%" />
			<col width="14%" />
			<col width="10%" />
			<col width="5%" />
			<col width="5%" />
			<col width="5%" />
			<col width="5%" />
			<col width="5%" />

		</colgroup-->
		<thead>
		<tr>
			<th  class="its-th-align center"  rowspan="3">
				<input type="checkbox"  name="checkboxAll" value="" id="checkboxAll" />
			</th>
			<th  class="its-th-align center"  rowspan="3"><span class="icon-star-gray <?php if($TPL_VAR["sc"]["orderby"]=='favorite_chk desc'){?>checked<?php }?> hand" id="order_star"></span></th>
			<th  class="its-th-align center" rowspan="2" colspan="4">주문</th>
			<th  class="its-th-align center" colspan="8">매출증빙</th>
			<th  class="its-th-align center" rowspan="2">환불</th>
			<th  class="its-th-align center" rowspan="3">메모</th>
		</tr>
		<tr>
			<th  class="its-th-align center" colspan="4">1. 신청</th>
			<th  class="its-th-align center" colspan="2">2. 처리</th>
			<th  class="its-th-align center" colspan="2">3. 결과</th>
		</tr>
		<tr>
			<th  class="its-th-align center" >주문번호<br>주문일</th>
			<th  class="its-th-align center" >주문자</th>
			<th  class="its-th-align center" >결제금액</th>
			<th  class="its-th-align center" >결제</th>
			<th  class="its-th-align center" >신청자<br>신청일</th>
			<th  class="its-th-align center" >신청정보</th>
			<th class="its-th-align center" >증빙자료</th>
			<th class="its-th-align center" >증빙금액</th>
			<th class="its-th-align center" >처리확정일</th>
			<th class="its-th-align center" >처리방법</th>
			<th class="its-th-align center" >전송로그</th>
			<th class="its-th-align center" >처리상태</th>
			<th class="its-th-align center" >환불번호</th>
			<!-- <th class="its-th-align center" rowspan="2">발급상태</th> -->
		</tr>
		</thead>
		<tbody class="ltb">
<?php if($TPL_VAR["salesloop"]){?>
<?php if($TPL_salesloop_1){foreach($TPL_VAR["salesloop"] as $TPL_V1){?>
		<tr >

			<td  class="its-td-align center">
				<input type="checkbox"  name="del[]" value="<?php echo $TPL_V1["seq"]?>"  class="checkeds"  value="<?php echo $TPL_V1["order_seq"]?>" typereceipt="<?php echo $TPL_V1["typereceipt"]?>" tstep="<?php echo $TPL_V1["tstep"]?>" />
			</td>

			<td  class="its-td-align center" ><span class="icon-star-gray star_select <?php echo $TPL_V1["favorite_chk"]?>" seq="<?php echo $TPL_V1["seq"]?>"></span></td>
<?php if($TPL_V1["row_number"]== 1||!$TPL_V1["row_number"]){?>
			<td class="its-td-align center" rowspan="<?php echo $TPL_VAR["arr_row_number"][$TPL_V1["order_seq"]]?>">
				<a href="view?no=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><span class="blue bold"><?php echo $TPL_V1["order_seq"]?></span></a>
<?php if($TPL_V1["order_date"]){?><br><?php echo $TPL_V1["order_date"]?><?php }?>
			</td>

			<td class="its-td-align center" rowspan="<?php echo $TPL_VAR["arr_row_number"][$TPL_V1["order_seq"]]?>">
<?php if($TPL_V1["member_seq"]> 0){?>
				<div class="userinfo hand" seq="<?php echo $TPL_V1["member_seq"]?>" style="padding-left:5px;">
<?php }else{?>
					<div class="userinfo" seq="" style="padding-left:5px;">
<?php }?>
<?php if($TPL_V1["order_name"]){?><?php echo $TPL_V1["order_name"]?>

<?php }elseif($TPL_V1["order_user_name"]){?><?php echo $TPL_V1["order_user_name"]?>

<?php }elseif($TPL_V1["person"]){?><?php echo $TPL_V1["person"]?>

<?php }else{?>비회원<?php }?>
<?php if($TPL_V1["userid"]){?><br />(<?php echo $TPL_V1["userid"]?>)<?php }?>
					</div>
			</td>
			<td class="its-td-align center" rowspan="<?php echo $TPL_VAR["arr_row_number"][$TPL_V1["order_seq"]]?>">
<?php if($TPL_V1["payment"]=='escrow_account'){?>
				<span class="icon-pay-escrow"><span>에스크로</span></span>
				<span class="icon-pay-account"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }elseif($TPL_V1["payment"]=='escrow_virtual'){?>
				<span class="icon-pay-escrow"><span>에스크로</span></span>
				<span class="icon-pay-virtual"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }else{?>
				<span class="icon-pay-<?php echo $TPL_V1["payment"]?>"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }?>
				<b><?php echo number_format($TPL_V1["settleprice"])?></b>
			</td>
			<td class="its-td-align center" rowspan="<?php echo $TPL_VAR["arr_row_number"][$TPL_V1["order_seq"]]?>">
<?php if($TPL_V1["mstep"]){?><?php if($TPL_V1["mstep"]=="주문접수"){?><font color="red"><?php }?><?php echo $TPL_V1["mstep"]?><?php if($TPL_V1["mstep"]=="주문접수"){?></font><?php }?><?php }else{?>-<?php }?>
			</td>
<?php }?>
			<td class="its-td-align center" style="padding-left:3px;">
<?php if($TPL_V1["type"]== 1){?>관리자<?php }elseif($TPL_V1["type"]== 3){?>자진 발급<?php }else{?>구매자<?php }?>
<?php if($TPL_V1["regdate"]){?><br/><?php echo substr($TPL_V1["regdate"], 0, 10)?><?php }elseif($TPL_V1["order_date"]){?><br/><?php echo substr($TPL_V1["order_date"], 0, 10)?><?php }?>
			</td>
			<td class="its-td-align center">
<?php if($TPL_V1["typereceipt"]=="1"){?>
				<div><span class="btn small gray"><input type="button" name="tax_view" seq="<?php echo $TPL_V1["seq"]?>" order_seq ="<?php echo $TPL_V1["order_seq"]?>" value="보기" /></span></div>
<?php if($TPL_V1["email_chk"]){?><span style="color:red;">이메일 오류</span><?php }?>
<?php }elseif($TPL_V1["typereceipt"]=="2"){?>
				<div><span class="btn small gray"><input type="button" name="cash_view" seq="<?php echo $TPL_V1["seq"]?>" order_seq ="<?php echo $TPL_V1["order_seq"]?>" value="보기" /></span></div>
<?php }?>
			</td>
			<td class="its-td-align center">

<?php if($TPL_V1["typereceipt"]=="1"){?><img src="/admin/skin/default/images/common/btn_evi_tax<?php if($TPL_V1["surtax"]== 0){?>2<?php }else{?>1<?php }?>.gif"  />
<?php }elseif($TPL_V1["typereceipt"]=="2"){?>
<?php if($TPL_V1["cash_no"]){?>
				<button name="pgcashbtn2" order_seq ="<?php echo $TPL_V1["order_seq"]?>" tno="<?php echo $TPL_V1["pg_transaction_number"]?>" authdata="<?php echo $TPL_V1["authdata"]?>" pg_kind="<?php echo $TPL_V1["pg_kind"]?>" cash_receipts_no="<?php echo $TPL_V1["cash_no"]?>" settleprice="<?php echo $TPL_V1["price"]?>" payment="<?php echo $TPL_V1["payment"]?>" style="border:0px;"/><img src="/admin/skin/default/images/common/btn_evi_cash_on.gif" border=0></button>
<?php }else{?>
				<img src="/admin/skin/default/images/common/btn_evi_cash.gif"  />
<?php }?>
<?php }else{?>
				<button name="pgreceiptbtn" order_seq ="<?php echo $TPL_V1["order_seq"]?>" tno="<?php echo $TPL_V1["pg_transaction_number"]?>" authdata="<?php echo $TPL_V1["authdata"]?>" pg_kind="<?php echo $TPL_V1["pg_kind"]?>" payment="<?php echo $TPL_V1["payment"]?>" style="border:0px;" /><img src="/admin/skin/default/images/common/btn_evi_order_on.gif"  /></button>
<?php }?>
			</td>
			<td class="its-td-align">
<?php if($TPL_V1["typereceipt"]=="1"){?>
				<table width="80%" align="center">
					<tr>
						<td align="left">공급가 : </td>
						<td align="right"><?php echo number_format($TPL_V1["supply"])?>원</td>
					</tr>
					<tr>
						<td align="left">부가세 : </td>
						<td align="right"><?php echo number_format($TPL_V1["surtax"])?>원</td>
					</tr>
					<tr>
						<td align="left">합 &nbsp;&nbsp;계 : </td>
						<td align="right"><?php echo number_format($TPL_V1["price"])?>원</td>
					</tr>
				</table>
<?php }else{?>
				<table width="80%" align="center">
					<tr>
						<td align="left">공급가 : </td>
						<td align="right"><?php echo number_format($TPL_V1["supply"])?>원</td>
					</tr>
					<tr>
						<td align="left">부가세 : </td>
						<td align="right"><?php echo number_format($TPL_V1["surtax"])?>원</td>
					</tr>
					<tr>
						<td align="left">합 &nbsp;&nbsp;계 : </td>
						<td align="right"><?php echo number_format($TPL_V1["price"])?>원</td>
					</tr>
				</table>
<?php }?>
			</td>
			<td class="its-td-align center">
				<?php echo substr($TPL_V1["up_date"], 0, 10)?>

			</td>
			<td class="its-td-align center">
<?php if($TPL_V1["typereceipt"]=="0"){?>
				자동
<?php }elseif($TPL_V1["typereceipt"]=="1"||$TPL_V1["typereceipt"]=="2"){?>
<?php if($TPL_V1["tstep"]== 1){?>
				<span class="btn small gray">
<?php if($TPL_V1["refund"]){?>
					<input type="button" value="연동처리" style="width:70px;" onclick="alert('환불건이 있는 매출증빙 자료 입니다.\n수기로 발행해 주십시오.');"/>
<?php }else{?>
					<input type="button" <?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');" <?php }else{?> name="link_btn" <?php }?> seq="<?php echo $TPL_V1["seq"]?>" order_seq ="<?php echo $TPL_V1["order_seq"]?>" typereceipt="<?php echo $TPL_V1["typereceipt"]?>" value="연동처리" step="<?php echo $TPL_V1["mstep"]?>" style="width:70px;"/>
<?php }?>
				</span>
				<div class="clearbox" style="height:3px;"></div>
				<span class="btn small gray"><input type="button" <?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');" <?php }else{?> name="unlink_btn" seq="<?php echo $TPL_V1["seq"]?>" order_seq ="<?php echo $TPL_V1["order_seq"]?>" <?php }?> value="미연동처리" step="<?php echo $TPL_V1["mstep"]?>" style="width:70px;"/></span>
				<div class="clearbox" style="height:3px;"></div>
				<span class="btn small gray"><input type="button" <?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');" <?php }else{?> name="cancel_btn" seq="<?php echo $TPL_V1["seq"]?>" order_seq ="<?php echo $TPL_V1["order_seq"]?>" <?php }?> value="취  소" step="<?php echo $TPL_V1["mstep"]?>" style="width:70px;"/></span>
<?php }elseif($TPL_V1["tstep"]!='3'&&$TPL_V1["approach"]){?>
<?php if($TPL_V1["approach"]=="link"){?>연동처리
<?php }elseif($TPL_V1["approach"]=="unlink"){?>미연동처리
<?php }elseif($TPL_V1["approach"]=="auto"){?>자동
<?php }else{?>연동처리	<?php }?>
<?php }elseif($TPL_V1["tstep"]!='3'){?>
				연동처리
<?php }?>
<?php }?>
			</td>
			<td class="its-td-align center">
<?php if($TPL_V1["approach"]=="unlink"||$TPL_V1["typereceipt"]== 0||$TPL_V1["tstep"]== 1){?>
				<span class="gray">보기</span>
<?php }else{?>
				<span onclick="tax_send_log('<?php echo $TPL_V1["seq"]?>');" style="cursor:pointer;color:#3366ff;">보기</span>
<?php }?>
			</td>
			<td class="its-td-align center">
<?php if($TPL_V1["typereceipt"]=="0"){?>
				완료
<?php }else{?>
<?php if($TPL_V1["tstep"]== 2){?>완료
<?php }elseif($TPL_V1["tstep"]== 1){?>대기
<?php }elseif($TPL_V1["tstep"]== 3){?>취소
<?php }elseif($TPL_V1["tstep"]== 4){?>완료(연동실패) <br />
				<span onclick="guidefail();" style="cursor:pointer;color:#3366ff;">안내</span>
<?php }elseif($TPL_V1["tstep"]== 5){?>완료
<?php }else{?>없음
<?php }?>
<?php if($TPL_V1["tstep"]!='3'&&$TPL_V1["approach"]){?>
<?php if($TPL_V1["approach"]=="link"){?>(연동)
<?php }elseif($TPL_V1["approach"]=="unlink"){?>(미연동)
<?php }elseif($TPL_V1["approach"]=="auto"){?>(자동)
<?php }else{?>(자동)	<?php }?>
<?php }else{?>
<?php if($TPL_V1["tstep"]=='2'&&!$TPL_V1["approach"]){?>(연동)<?php }?>
<?php }?>
<?php }?>
			</td>
			<td class="its-td-align center">
<?php if($TPL_V1["refund"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["refund"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<a href="/admin/refund/view?no=<?php echo $TPL_V2["refund_code"]?>" target="_blank"><?php echo $TPL_V2["refund_code"]?></a><br>
<?php }}?>
<?php }?>
			</td>
			<td class="its-td-align center">
				<span class="btn small gray"><input type="button" onclick="sales_memo('<?php echo $TPL_V1["seq"]?>', '<?php echo $TPL_V1["order_seq"]?>');" value="<?php if($TPL_V1["admin_memo"]){?>보기<?php }else{?>등록<?php }?>" step="<?php echo $TPL_V1["mstep"]?>"/></span>
			</td>
		</tr>
<?php }}?>
<?php }else{?>
		<tr >
			<td class="its-td-align center" colspan="16">
<?php if($TPL_VAR["search_text"]){?>
				'<?php echo $TPL_VAR["search_text"]?>' 검색된 주문이이 없습니다.
<?php }else{?>
				주문이 없습니다.
<?php }?>
			</td>
		</tr>
<?php }?>
		</tbody>
	</table>
</div>
<!-- 서브 레이아웃 영역 : 끝 -->

<!-- 페이징 -->
<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>

<div id="guidefail" class="hide">
	<div class="fx12 mt10">
		1. 수동으로 매출증빙을 처리하십시오.<br />
		&nbsp;&nbsp;&nbsp;※ 페이지 우측 상단에 수동 신청버튼이 있습니다.
	</div>
	<div class="fx12 mt15">
		2. 해당 매출증빙 신청건(연동처리 실패)에는 메모(수동처리 등)을 남겨 관리하십시오.
	</div>
</div>

<div id="taxlay" class="hide">
	<table class="info-table-style" width="100%" cellspacing="0">
		<colgroup>
			<col width="100px" />
			<col width="" />
		</colgroup>
		<tbody>
		<tr>
			<th  class="its-th-align center">발급상태</th>
			<td  class="its-td"><span id="tax_tstep" ></span></td>
		</tr>
		<tr>
			<th  class="its-th-align center">종 류</th>
			<td  class="its-td"><span id="vat_msg" ></span></td>
		</tr>
		<tr>
			<th  class="its-th-align center">주문번호</th>
			<td  class="its-td"><span id="tax_order_seq" ></span></td>
		</tr>
		<tr>
			<th  class="its-th-align center">상호명</th>
			<td  class="its-td"><span id="co_name" ></span></td>
		</tr>
		<tr>
			<th  class="its-th-align center">사업자번호</th>
			<td  class="its-td"><span id="busi_no" ></span></td>
		</tr>

		<tr>
			<th  class="its-th-align center">대표자명</th>
			<td  class="its-td"><span id="co_ceo" ></span></td>
		</tr>

		<tr>
			<th  class="its-th-align center">업태/업종</th>
			<td  class="its-td"><span id="co_status" ></span>/<span id="co_type" ></span></td>
		</tr>
		<tr>
			<th  class="its-th-align center">주소</th>
			<td  class="its-td"><span id="address" ></span></td>
		</tr>
		<tr>
			<th  class="its-th-align center">담당자이름</th>
			<td  class="its-td">
				<span id="tax_person" ></span></td>
		</tr>
		<tr>
			<th  class="its-th-align center">담당자 이메일</th>
			<td  class="its-td">
				<span id="tax_email" ></span></td>
		</tr>
		<tr>
			<th  class="its-th-align center">전화번호</th>
			<td  class="its-td">
				<span id="tax_phone" ></span>
			</td>
		</tr>

		<tr>
			<th  class="its-th-align center">금액</th>
			<td  class="its-td">
				<table style="border:none;">
					<tr>
						<td style="border:none;">합 계</td>
						<td style="border:none;"> : </td>
						<td style="border:none;text-align:right;"><span id="tax_price" ></span>원</td>
					</tr>
					<tr>
						<td style="border:none;">공급가액</td>
						<td style="border:none;"> : </td>
						<td style="border:none;text-align:right;"><span id="tax_supplylay" ></span>원</td>
					</tr>
					<tr>
						<td style="border:none;">부 가 세</td>
						<td style="border:none;"> : </td>
						<td style="border:none;text-align:right;"><span id="tax_surtaxlay" ></span>원</td>
					</tr>
				</table>
			</td>
		</tr>
		</tbody>
	</table>
</div>

<div id="tax_send_log" class="hide"></div>
<div id="cash_lay" class="hide">
	<table class="info-table-style" width="100%" cellspacing="0">
		<colgroup>
			<col width="100px" />
			<col width="" />
		</colgroup>
		<tbody>
		<tr>
			<th  class="its-th-align center">발급상태</th>
			<td  class="its-td"><span id="cash_msg" ></span></td>
		</tr>
		<tr>
			<th  class="its-th-align center">거래일시</th>
			<td  class="its-td"><span id="cash_order_date" ></span></td>
		</tr>
		<tr>
			<th  class="its-th-align center">주문번호</th>
			<td  class="its-td"><span id="cash_order_seq" ></span></td>
		</tr>
		<tr>
			<th  class="its-th-align center">발행용도</th>
			<td  class="its-td"><span id="cuse" ></span></td>
		</tr>
		<tr>
			<th  class="its-th-align center">인증번호</th>
			<td  class="its-td"><span id="r_creceipt_number" ></span></td>
		</tr>
		<tr>
			<th  class="its-th-align center">주문자명</th>
			<td  class="its-td"><span id="person" ></span></td>
		</tr>
		<tr>
			<th  class="its-th-align center">이메일</th>
			<td  class="its-td"><span id="email" ></span></td>
		</tr>
		<tr class="cash_phone">
			<th  class="its-th-align center">전화번호</th>
			<td  class="its-td"><span id="phone" ></span></td>
		</tr>
		<tr>
			<th  class="its-th-align center">상품명</th>
			<td  class="its-td"><span id="goodsname" ></span></td>
		</tr>
		<tr>
			<th  class="its-th-align center">금액</th>
			<td  class="its-td" >
				<table style="border:none;">
					<tr>
						<td style="border:none;">합 계</td>
						<td style="border:none;"> : </td>
						<td style="border:none;text-align:right;"><span id="price" ></span>원</td>
					</tr>
					<tr>
						<td style="border:none;">공급가액</td>
						<td style="border:none;"> : </td>
						<td style="border:none;text-align:right;"><span id="supply" ></span>원</td>
					</tr>
					<tr>
						<td style="border:none;">부 가 세</td>
						<td style="border:none;"> : </td>
						<td style="border:none;text-align:right;"><span id="surtax" ></span>원</td>
					</tr>
				</table>
			</td>
		</tr>
		</tbody>
	</table>
</div>

<div id="cashreceiptlay" class="hide">
	<form name="cashreceiptform" id="cashreceiptform" method="post" action="../sales_process/cashreceipt_regist" onSubmit="return false;" target="actionFrame">
		<input type="hidden" name="mode" value="add" />
		<input type="hidden" name="seq" value="" />
		<table class="info-table-style" width="100%" cellspacing="0">
			<colgroup>
				<col width="80px" />
				<col width="" />
			</colgroup>
			<tbody>
			<tr class="order_date hide">
				<th  class="its-th-align center">거래일시</th>
				<td  class="its-td">
					<input type="text" name="order_date" class="line" maxlength="14" /><span id="order_date_cash"></span>
				</td>
			</tr>
			<tr>
				<th  class="its-th-align center">주문번호</th>
				<td  class="its-td">
					<span class="btn small gray has_order"><button type="button" onclick="order_search('chkvoucher_cash');">검색</button></span>
					<input type="hidden" class="selected_order_seq" name="order_seq" value=""/>
					<span class="hide red bold selected_order_seq_txt"></span>
				</td>
			</tr>
			<tr>
				<th  class="its-th-align center">발행용도</th>
				<td  class="its-td">
					<input type="radio" name="cuse" id="cuse0" value="0" checked="checked" /> <label for="cuse0" ><span>개인 소득공제용</span></label>
					<input type="radio" name="cuse" id="cuse1" value="1"/> <label for="cuse1" ><span>사업자지출 증빙용</span></label> <br />

				</td>
			</tr>
			<tr>
				<th  class="its-th-align center">인증번호</th>
				<td  class="its-td">  <div id="personallay"  >
					주민(휴대폰)번호 <input type="text" name="creceipt_number[0]" class="line number" maxlength="13"/>(<span class="comment">"-" 없이 입력.</span>)
				</div>
					<div id="businesslay" class="hide" >
						사업자번호 <input type="text" name="creceipt_number[1]" class="line number" maxlength="10"/>(<span class="comment">"-" 없이 입력</span>)
					</div>
				</td>
			</tr>
			<tr>
				<th  class="its-th-align center">주문자명</th>
				<td  class="its-td"> <input type="text" name="name" class="line  " /></td>
			</tr>
			<!--
            <tr>
                <th  class="its-th-align center">주문번호</th>
                <td  class="its-td"> <input type="text" name="order_seq" class="line  " /></td>
            </tr>
            -->
			<tr>
				<th  class="its-th-align center">이메일</th>
				<td  class="its-td"> <input type="text" name="email" class="line  " /></td>
			</tr>
			<tr class="cash_phone">
				<th  class="its-th-align center">전화번호</th>
				<td  class="its-td">
					<input type="text" name="phone" class="line" /> (“-” 없이 입력)
				</td>
			</tr>
			<tr>
				<th  class="its-th-align center">상품명</th>
				<td  class="its-td"> <input type="text" name="goodsname" class="line" /><span id="goodsname_cash" ></span></td>
			</tr>
			<tr>
				<th  class="its-th-align center">과세/비과세</th>
				<td  class="its-td">
					<label class="vat_type_label"><input type="radio" name="vat_type" value="2"/> <span>비과세</span></label>
					<label class="vat_type_label"><input type="radio" name="vat_type" value="1" checked="checked" /> <span>과세</span></label>
					<span id="vat_type_cash"></span>
				</td>
			</tr>
			<tr>
				<th  class="its-th-align center">발행액</th>
				<td  class="its-td">
					발행액 : <input type="text" name="amount" id="amount" value="" size="10"   label="발행액"  >원<br>
					공급액 : <input type="text" id="supplylay" value="" size="10" readonly="readonly" disabled="disabled" >원<br>
					부가세 : <input type="text" id="surtaxlay" value="" size="10" readonly="readonly"  disabled="disabled">원

					<input type="hidden" name="supply"  id="supply1" value="" >
					<input type="hidden" name="surtax"  id="surtax1" value="" >
				</td>
			</tr>
			<tr>
				<td class="its-td-align center" colspan="2">
					<span class="btn large black"><input type="submit" id="download_create_cash"  value="등록" /></span>
					<span class="btn large black"><input type="button" id="download_cancel_cash"  value="취소" onclick="$('#cashreceiptlay').dialog('close');"/></span>
				</td>
			</tr>
			</tbody>
		</table>
	</form>
</div>


<div id="tax_layer" class="hide">
	<form name="taxform" id="taxform" method="post" action="../sales_process/tax_regist" onSubmit="return false;" target="actionFrame">
		<input type="hidden" name="mode" value="add" />
		<input type="hidden" name="seq" value="" />
		<table class="info-table-style" width="100%" cellspacing="0">
			<colgroup>
				<col width="100px" />
				<col width="" />
			</colgroup>
			<tbody>
			<tr>
				<th  class="its-th-align center">발급상태</th>
				<td  class="its-td"><span id="tstep_tax" ></span></td>
			</tr>
			<tr id="tax_gubun">
				<th  class="its-th-align center">종류</th>
				<td  class="its-td">
					<label><input type="radio" name="vat_type" value="1" /> 세금계산서</label>
					<label style="margin-left:5px;"><input type="radio" name="vat_type" value="2" checked /> 일반계산서</label>
				</td>
			</tr>
			<tr>
				<th  class="its-th-align center">주문번호</th>
				<td  class="its-td">
					<span class="hide red bold selected_order_seq_txt"></span>
					<span class="btn small gray has_order"><button type="button" onclick="order_search('chkvoucher_tax');">검색</button></span>
					<input type="hidden" class="selected_order_seq" name="order_seq" value=""/>
					<span class="hide red bold" id="order_seq_tax" ></span>
				</td>
			</tr>
			<tr>
				<th  class="its-th-align center">상호명</th>
				<td  class="its-td"> <input type="text" name="co_name" class="line  " style="width:90%;"/></td>
			</tr>
			<tr>
				<th  class="its-th-align center">사업자번호</th>
				<td  class="its-td">
					<input type="text" name="busi_no" class="line" maxlength="12"/>
					<span class="comment">(ex)123-12-12345</span>
				</td>
			</tr>
			<tr>
				<th  class="its-th-align center">대표자명</th>
				<td  class="its-td"> <input type="text" name="co_ceo" class="line  " /></td>
			</tr>
			<tr>
				<th  class="its-th-align center">업태/업종</th>
				<td  class="its-td">
					<input type="text" name="co_status" class="line" size="15" />
					/
					<input type="text" name="co_type" class="line" size="15" />
				</td>
			</tr>
			<tr>
				<th  class="its-th-align center">주소</th>
				<td  class="its-td">
					<input type="text" name="Zipcode[]" value="" size="7"/> <span class="btn small"><input type="button" id="zipcodeButton" value="주소찾기" /></span><br>
					<input type="hidden" name="Address_type" value="" size="50"/>
					(지번) <input type="text" name="Address" value="" size="42" readonly/><br>
					(도로명) <input type="text" name="Address_street" value="" size="40" readonly/><br>
					(공통상세) <input type="text" name="Address_detail" value="" size="38"/>
				</td>
			</tr>
			<tr>
				<th  class="its-th-align center">담당자이름</th>
				<td  class="its-td">
					<input type="text" name="person" class="line" /></td>
			</tr>
			<tr>
				<th  class="its-th-align center">담당자 이메일</th>
				<td  class="its-td">
					<input type="text" name="email" class="line" /></td>
			</tr>
			<tr>
				<th  class="its-th-align center">전화번호</th>
				<td  class="its-td">
					<input type="text" name="phone" class="line" />
					<span class="comment">(“-” 없이 입력)</span>
				</td>
			</tr>
			<tr>
				<th  class="its-th-align center">금 액</th>
				<td  class="its-td">
					합 &nbsp; 계 : <input type="text" name="amount" id="amount2" value="" size="10"   label="발행액"  >원<br>
					공급액 : <input type="text"  id="supplylay2" value="" size="10" readonly="readonly" disabled="disabled" >원<br>
					부가세 : <input type="text" id="surtaxlay2" value="" size="10" readonly="readonly"  disabled="disabled">원

					<input type="hidden" name="supply"  id="supply2" value="" >
					<input type="hidden" name="surtax"  id="surtax2" value="" >
				</td>
			</tr>
			<tr>
				<td class="its-td-align center" colspan="2">
					<span class="btn large black"><input type="submit" id="download_create_tax"  value="등 록" /></span>
					<span class="btn large black"><input type="button" id="download_cancel_tax"  value="취 소" onclick="$('#tax_layer').dialog('close');"/></span>
				</td>
			</tr>
			</tbody>
		</table>
	</form>
</div>
<div id="memo_layer" class="hide">
	<form name="memofrm" id="memofrm" method="post" action="../sales_process/memo_regist" target="actionFrame">
		<input type="hidden" name="sales_seq" id="sales_seq" value="" />
		<input type="hidden" name="order_seq" id="order_seq" value="" />
		<table class="info-table-style" width="100%" cellspacing="0">
			<colgroup>
				<col width="100px" />
				<col width="" />
			</colgroup>
			<tbody>
			<tr>
				<th  class="its-th-align center">주문번호</th>
				<td  class="its-td" id="memo_order_seq"></td>
			</tr>
			<tr>
				<th  class="its-th-align center">관리자 메모</th>
				<td  class="its-td">
					<textarea name="sales_memo" id="sales_memo" style="width:95%" rows="15"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" height="10"></td>
			</tr>
			<tr>
				<td class="center" colspan="2">
					<span class="btn large black"><input type="submit" value="등록" id="btn_td"></span>
					<span class="btn large black"><input type="button" value="취소" onclick="$('#memo_layer').dialog('close');"></span>
				</td>
			</tr>
		</table>
	</form>
</div>

<!-- 기본검색설정 -->
<script type="text/javascript" src="/app/javascript/js/admin-searchDefaultConfig.js"></script>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>