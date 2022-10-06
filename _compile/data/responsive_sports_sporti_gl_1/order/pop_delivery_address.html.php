<?php /* Template_ 2.2.6 2022/03/18 15:13:30 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/order/pop_delivery_address.html 000012581 */ 
$TPL_add_loop_1=empty($TPL_VAR["add_loop"])||!is_array($TPL_VAR["add_loop"])?0:count($TPL_VAR["add_loop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 다른 배송지 목록( 신청/결제 > 배송지 > 다른배송지 선택 > 선택 목록 ) @@
- 파일위치 : [스킨폴더]/order/pop_delivery_address.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<script type="text/javascript">
$(document).ready(function(){
	// 해당 주소 최종 선택
	$("input[name='select_address']").bind("click",function(){
		var add_seq = $(this).val();
		$.ajax({
			url: '/mypage/delivery_address_ajax',
			data : {'address_seq':add_seq},
			dataType : 'json',
			success: function(data) {
				$("input[name='address_group']").val(data.address_group);

				if(data.defaults=='Y'){
					$("input[name='save_delivery_address']").attr('checked',true);
				}else{
					$("input[name='save_delivery_address']").removeAttr('checked');
				}

				// 국가 정보 없는경우 재 등록요구 :: 2016-08-03 lwh
				if(!data.nation && data.international == 'international'){
					alert('배송국가가 지정되지 않았습니다.\n수정을 통해 배송국가를 지정해주세요.');
					return;
				}

				if(data.nation == 'KOREA' || data.international == 'domestic'){
					// input values
					$("#international").val('0');
					$(".kr_zipcode").show();
					
					$("input[name='recipient_input_address_type']").val(data.recipient_address_type);
					$("input[name='recipient_input_address']").val(data.recipient_address);
					$("input[name='recipient_input_address_street']").val(data.recipient_address_street);
					$("input[name='recipient_input_address_detail']").val(data.recipient_address_detail);
					$("input[name='recipient_input_new_zipcode']").eq(0).val(data.recipient_new_zipcode);
					
					// span values
					$(".recipient_zipcode").html(data.recipient_new_zipcode);
					if(data.recipient_address_type == 'street'){
						$(".recipient_address").html(data.recipient_address_street);
					}else{
						$(".recipient_address").html(data.recipient_address);
					}

					//$(".recipient_address_street.data2").html(data.recipient_address_street); // 주문배송내역
					//$(".recipient_address.data2").html(data.recipient_address); // 주문배송내역

					$(".recipient_address_detail").html(data.recipient_address_detail);
					$(".international_nation").html('대한민국');
					$("#address_nation").val('KOREA').trigger('change');
				}else{
					// input values
					$("#international").val('1');
					$(".kr_zipcode").hide();

					$("select[name='region']").val(data.region);
					$("input[name='international_county_input']").val(data.international_county);
					$("input[name='international_address_input']").val(data.international_address);
					$("input[name='international_town_city_input']").val(data.international_town_city);
					$("input[name='international_postcode_input']").val(data.international_postcode);
					$("input[name='international_country_input']").val(data.international_country);

					// span values
					var international_address = data.international_address + ',' + data.international_town_city + ',' + data.international_county + ',' + data.international_postcode + ',' + data.international_country;
					$(".recipient_address").html(international_address);
					$(".international_nation").html(data.nation);
					//$(".nation_name.data2").html(data.nation); // 주문배송내역
					$("#address_nation").val(data.nation).trigger('change');
				}

				// 공통 부분 input values
				$("input[name='address_description_input']").val(data.address_description);
				$("input[name='recipient_input_user_name']").val(data.recipient_user_name);
				if (data.recipient_phone != null) {
					phone = new Array();
					phone = data.recipient_phone.split('-');
					$(".delivery_input").find("input[name='recipient_input_phone[]']").each(function(idx){
						$(".delivery_input").find("input[name='recipient_input_phone[]']").eq(idx).val(phone[idx]);
					});
				}
				if (data.recipient_cellphone != null) {
					cellphone = new Array();
					cellphone = data.recipient_cellphone.split('-');
					$(".delivery_input").find("input[name='recipient_input_cellphone[]']").each(function(idx){
						$(".delivery_input").find("input[name='recipient_input_cellphone[]']").eq(idx).val(cellphone[idx]);
					});
				}
				// 공통 부분 span values
				$(".recipient_user_name").html(data.recipient_user_name);
				$(".cellphone").html(data.recipient_cellphone);
				//$(".recipient_cellphone.data2").html(data.recipient_cellphone); // 주문배송내역
				$(".phone").html(data.recipient_phone);
				//$(".recipient_phone.data2").html(data.recipient_phone); // 주문배송내역

				address_close('delivery');
			}
		});
	});
});

// 주소록 페이징
function popDeliverypage(params){
	$.ajax({
		'url'	: '/order/pop_delivery_address',
		'data'	: params,
		'type'	: 'get',
		'dataType': 'text',
		'success': function(html) {
			if(html){
				$(".delivery_often").html(html);
			}else{
				alert("주소록을 로드하지 못했습니다.");
				document.location.reload();
			}
		}
	});
}

// 배송지 수정
function delivery_modify(seq){
	// 두번째 입력탭으로 이동시킴
	$(".settle_tab li").removeClass("current");
	$(".input_tab").addClass("current");
	var $boxVar = $(".input_tab").index() + 1;
	$(".settle_tab_contents").css("display","none");
	$(".settle_tab_contents.tab_box"+$boxVar).css("display","block");
	
	// 데이터를 추출하여 input에 강제로 삽입
	$.ajax({
		url: '/mypage/delivery_address_ajax',
		data : {'address_seq':seq},
		dataType : 'json',
		success: function(data) {
			if(data.nation == '') data.nation = 'KOREA';

			// input box 초기화
			$(".delivery_input").find("input").val('');
			$(".delivery_input").find("input[name='address_group_input']").val(data.address_group);

			if(data.defaults=='Y'){
				$(".delivery_input").find("input[name='save_delivery_address_input']").attr('checked',true);
			}else{
				$(".delivery_input").find("input[name='save_delivery_address_input']").removeAttr('checked');
			}
			chg_shipping_nation(data.nation);
			if(data.nation == 'KOREA' || data.international == 'domestic'){
				$(".delivery_input").find("select[name='nation_select']").val('KOREA');
				$(".delivery_input").find("input[name='address_description_input']").val(data.address_description);
				$(".delivery_input").find("input[name='recipient_input_user_name']").val(data.recipient_user_name);
				$(".delivery_input").find("input[name='recipient_input_address_type']").val(data.recipient_address_type);
				$(".delivery_input").find("input[name='recipient_input_address']").val(data.recipient_address);
				$(".delivery_input").find("input[name='recipient_input_address_street']").val(data.recipient_address_street);
				$(".delivery_input").find("input[name='recipient_input_address_detail']").val(data.recipient_address_detail);
				$(".delivery_input").find("input[name='recipient_input_new_zipcode']").eq(0).val(data.recipient_new_zipcode);

			}else{
				$(".delivery_input").find("select[name='nation_select']").val(data.nation);
				$(".delivery_input").find("input[name='address_description']").val(data.address_description);
				$(".delivery_input").find("input[name='recipient_input_user_name']").val(data.recipient_user_name);
				$(".delivery_input").find("select[name='region']").val(data.region);
				$(".delivery_input").find("input[name='international_county_input']").val(data.international_county);
				$(".delivery_input").find("input[name='international_address_input']").val(data.international_address);
				$(".delivery_input").find("input[name='international_town_city_input']").val(data.international_town_city);
				$(".delivery_input").find("input[name='international_postcode_input']").val(data.international_postcode);
				$(".delivery_input").find("input[name='international_country_input']").val(data.international_country);
			}

			phone = new Array();
			phone = data.recipient_phone.split('-');
			$(".delivery_input").find("input[name='recipient_input_phone[]']").each(function(idx){
				$(".delivery_input").find("input[name='recipient_input_phone[]']").eq(idx).val(phone[idx]);
			});

			cellphone = new Array();
			cellphone = data.recipient_cellphone.split('-');
			$(".delivery_input").find("input[name='recipient_input_cellphone[]']").each(function(idx){
				$(".delivery_input").find("input[name='recipient_input_cellphone[]']").eq(idx).val(cellphone[idx]);
			});

			chg_address_nation($(".delivery_input").find("select[name='nation_select']"));

			$(".delivery_input").find("input[name='insert_mode']").val('update');
			$(".delivery_input").find("input[name='address_seq']").val(seq);

			set_shipping('delivery');

			openDialog("배송지 수정 하기", "inAddress", {"width":550,"height":420});
		}
	});
}

// 배송지 삭제
function delivery_delete(seq){
	//정말 삭제하시겠습니까?
	var chk = confirm(getAlert('os154'));
	if(chk == true){
		var str="../mypage_process/delete_address?address_seq=" + seq + "&page_type=mobile";
		$("iframe[name='actionFrame']").attr('src',str);
	}
}
</script>

<?php if($TPL_VAR["add_loop"]){?>
<ul class="ul_delivery">
<?php if($TPL_add_loop_1){$TPL_I1=-1;foreach($TPL_VAR["add_loop"] as $TPL_V1){$TPL_I1++;?>
	<li class="<?php if($TPL_I1== 0){?>clearbox<?php }?>">
		<label for="select_address_<?php echo $TPL_V1["address_seq"]?>">
			<input type="radio" id="select_address_<?php echo $TPL_V1["address_seq"]?>" name="select_address" value="<?php echo $TPL_V1["address_seq"]?>" />
		</label>
		<ul class="list">
			<li class="name_section">
				<div class="btn_x1">
					<a href="javascript:void(0)" class="btn_resp" onclick="delivery_modify('<?php echo $TPL_V1["address_seq"]?>');">수정</a>
<?php if($TPL_V1["default"]!='Y'){?>
					<a href="javascript:void(0)" class="btn_resp" onclick="delivery_delete('<?php echo $TPL_V1["address_seq"]?>');">삭제</a>
<?php }?>
				</div>
				<label class="name_label" for="select_address_<?php echo $TPL_V1["address_seq"]?>">
					<span class="name"><?php echo $TPL_V1["recipient_user_name"]?></span>
<?php if($TPL_V1["address_description"]){?>
					<span class="desc">(<?php echo $TPL_V1["address_description"]?>)</span>
<?php }?>
<?php if($TPL_V1["default"]=='Y'){?>
					<span class="pointcolor">&nbsp;기본배송지</span>
<?php }?>
				</label>
			</li>
			<li class="address_section">
				<label for="select_address_<?php echo $TPL_V1["address_seq"]?>">
<?php if($TPL_V1["international"]=='domestic'){?>
					(<?php echo $TPL_V1["recipient_zipcode"]?>)
<?php if($TPL_V1["recipient_address_type"]=='street'){?>
					<?php echo $TPL_V1["recipient_address_street"]?>

<?php }else{?>
					<?php echo $TPL_V1["recipient_address"]?>

<?php }?>
					<?php echo $TPL_V1["recipient_address_detail"]?>

<?php }else{?>
					<?php echo $TPL_V1["international_address"]?>, <?php echo $TPL_V1["international_town_city"]?>,<?php echo $TPL_V1["international_county"]?>, <?php echo $TPL_V1["international_postcode"]?>,<?php echo $TPL_V1["international_country"]?>

<?php }?>
				</label>
			</li>
			<li class="call_section">
				<label for="select_address_<?php echo $TPL_V1["address_seq"]?>">
<?php if($TPL_V1["recipient_cellphone"]=='--'||!$TPL_V1["recipient_cellphone"]){?>휴대폰번호 없음<?php }else{?><?php echo $TPL_V1["recipient_cellphone"]?><?php }?> <?php if($TPL_V1["recipient_phone"]=='--'||!$TPL_V1["recipient_phone"]){?><?php }else{?><span class="gray_07">&nbsp;/&nbsp;</span> <?php echo $TPL_V1["recipient_phone"]?><?php }?>
				</label>
			</li>
			<li class="nation_section">
				<label for="select_address_<?php echo $TPL_V1["address_seq"]?>">
					배송국가 : <?php if($TPL_V1["international"]=='domestic'||$TPL_V1["nation"]=='KOREA'){?>대한민국<?php }else{?><?php echo $TPL_V1["nation"]?><?php }?>
				</label>
			</li>
		</ul>
	</li>
<?php }}?>
</ul>
<div class="paging_navigation Pb10 Mt0">
	<?php echo $TPL_VAR["page"]["html"]?>

</div>
<?php }else{?>
<div class="no_data_area Bx">등록된 배송지가 없습니다.</div>
<?php }?>