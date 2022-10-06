<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/mypage/export_list_goods.html 000010680 */ 
$TPL_export_1=empty($TPL_VAR["export"])||!is_array($TPL_VAR["export"])?0:count($TPL_VAR["export"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 배송조회 / 구매확정 @@
- 파일위치 : [스킨폴더]/mypage/export_list_goods.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="subpage_wrap">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"><!-- [스킨폴더]/mypage/mypage_lnb.html --></div>
	<!-- +++++ //mypage LNB ++++ -->

	<!-- +++++ mypage contents ++++ -->
	<div class="subpage_container">
		<!-- 전체 메뉴 -->
		<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)">MENU</a>

		<!-- 타이틀 -->
		<div class="title_container">
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvZXhwb3J0X2xpc3RfZ29vZHMuaHRtbA==" >배송조회 / 구매확정</span></h2>
		</div>


		<ul class="myorder_sort">
			<li class="list1">
				<span class="th">주문번호 :</span>
				<span class="td"><strong class="common_count v2"><?php echo $TPL_VAR["export"][ 0]["order_seq"]?></strong></span>
			</li>
		</ul>

		<div class="res_table">
			<ul class="thead">
				<li>상품</li>
				<li style="width:70px;">주문수량</li>
				<li style="width:70px;">발송수량</li>
				<li style="width:80px;">상품후기</li>
				<li style="width:150px;">발송정보</li>
			</ul>
<?php if($TPL_export_1){foreach($TPL_VAR["export"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["items"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
			<ul class="tbody <?php if($TPL_V2["opt_type"]!='opt'){?>suboptions<?php }?> <?php if($TPL_I2== 0){?><?php }else{?>besong_grouped<?php }?>">
				<li class="subject">
<?php if($TPL_V2["opt_type"]=='opt'){?>
					<ul class="board_goods_list">
						<li class="pic">
							<img src="<?php echo $TPL_V2["image"]?>" onerror="this.src='/data/skin/responsive_diary_petit_gl/images/common/noimage_list.gif'" alt="<?php echo $TPL_V2["goods_name"]?>" /></span>
						</li>
						<li class="info">
							<div class="title"><?php echo $TPL_V2["goods_name"]?></div>
<?php if($TPL_V2["option1"]){?>
							<div class="cont3">
								<span class="res_option_inline"><?php if($TPL_V2["title1"]){?><span class="xtle"><?php echo $TPL_V2["title1"]?></span><?php }?><?php echo $TPL_V2["option1"]?></span>
<?php if($TPL_V2["option2"]){?><span class="res_option_inline"><?php if($TPL_V2["title2"]){?><span class="xtle"><?php echo $TPL_V2["title2"]?></span><?php }?><?php echo $TPL_V2["option2"]?></span><?php }?>
<?php if($TPL_V2["option3"]){?><span class="res_option_inline"><?php if($TPL_V2["title3"]){?><span class="xtle"><?php echo $TPL_V2["title3"]?></span><?php }?><?php echo $TPL_V2["option3"]?></span><?php }?>
<?php if($TPL_V2["option4"]){?><span class="res_option_inline"><?php if($TPL_V2["title4"]){?><span class="xtle"><?php echo $TPL_V2["title4"]?></span><?php }?><?php echo $TPL_V2["option4"]?></span><?php }?>
<?php if($TPL_V2["option5"]){?><span class="res_option_inline"><?php if($TPL_V2["title5"]){?><span class="xtle"><?php echo $TPL_V2["title5"]?></span><?php }?><?php echo $TPL_V2["option5"]?></span><?php }?>
							</div>
<?php }?>
						</li>
					</ul>
<?php }else{?>
					<div class="reply_ui">
<?php if($TPL_V2["title1"]){?><span class="xtle v3"><?php echo $TPL_V2["title1"]?></span><?php }?> <?php echo $TPL_V2["option1"]?>

					</div>
<?php }?>
				</li>
				<li class="<?php echo $TPL_V2["opt_type"]?>"><span class="mtitle">주문:</span> <?php echo $TPL_V2["opt_ea"]?></li>
				<li class="<?php echo $TPL_V2["opt_type"]?> mo_end"><span class="mtitle">발송:</span> <?php echo $TPL_V2["ea"]?></li>
				<li class="<?php echo $TPL_V2["opt_type"]?>">
<?php if($TPL_V2["opt_type"]=='opt'){?>
					<button class="btn_resp res_board_boxad2" onclick="goods_review_write('<?php echo $TPL_V2["goods_seq"]?>','<?php echo $TPL_V1["order_seq"]?>');">상품후기</button>
<?php }?>
				</li>
<?php if($TPL_I2== 0){?>
				<li class="<?php echo $TPL_V2["opt_type"]?> besong_group2 left <?php if(count($TPL_V1["items"])> 1){?>rowspan<?php }?>" >
					<div class="rcont">
<?php if($TPL_V1["provider_name"]){?>
						<span class="gray_06">[<?php echo $TPL_V1["provider_name"]?>]</span>
<?php }?>
						<div class="pointcolor2"><?php echo $TPL_V1["export_date"]?> 발송</div>
						<div>[<?php echo $TPL_V1["mstatus"]?>]</div>
						<div><?php echo $TPL_V1["mdelivery"]?> <?php echo $TPL_V1["mdelivery_number"]?></div>
						<div class="btn_area_mx1">
<?php if($TPL_V1["tracking_url"]){?>
							<button type="button" class="btn_resp color2" onclick="window.open('<?php echo $TPL_V1["tracking_url"]?>');">배송조회</button>
<?php }?>
<?php if($TPL_V1["buyconfirmInfo"]['btn_buyconfirm']){?>
								<button type="button" class="btn_resp color2 exportbuyconfirm" export_code="<?php echo $TPL_V1["export_code"]?>" status="<?php echo $TPL_V1["status"]?>" >구매확정</button>
<?php }else{?>
<?php if($TPL_V1["buyconfirmInfo"]['reserve_buyconfirm_ea']){?>
									[구매확정]
<?php }?>
<?php }?>
						</div>
					</div>
				</li>
<?php }else{?>
				<li class="rowspaned"></li>
<?php }?>
			</ul>
<?php }}?>
<?php }}?>
		</div>

		<div class="btn_area_c">
			<a href="/mypage/order_catalog" class="btn_resp size_c color5">주문/배송 내역</a>
		</div>

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<!-- 구매 확정 및 마일리지/포인트 지급 -->
<div id="export_buy_confirm_msg" class="resp_layer_pop hide">
	<h4 class="title">구매 확정 및 마일리지/포인트 지급</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5">
			<input type="hidden" name="export_code" value="" />
			<input type="hidden" name="status" value="" />
			<div class="Pt10 Pb10">
				구매 확정 및 마일리지/포인트 지급을 받으시기 전에 반드시 아래사항을 확인하여 주세요.<br />
				확인 버튼 클릭 시 구매 확정 및 마일리지/포인트가 지급됩니다.<br />
			</div>
			<ul class="list_dot_01 box Mt10 gray_05">
				<li>주문 상품을 수령하셨고, 고객 변심 및 착오에 의한  교환 또는 환불의 의사가 없으실 경우 확인해주세요. 확인 후 즉시 마일리지/포인트가 지급됩니다.</li>
				<li>동일 주문건의 상품 중 일부 만 교환 또는 반품을 원하실 경우 주문 번호 클릭 후 세부 주문내역에서  개별 상품에  대한 구매확정을 해주셔야 합니다.</li>
				<li>구매 확정으로 마일리지/포인트가 지급된 이후 또는 제품 착용 시  교환 또는 환불이 불가합니다.</li>
<?php if($TPL_VAR["cfg_order"]["save_type"]=='exist'){?>
				<li>구매 확정을 하시지 않으시면 출고 완료 후  <?php echo $TPL_VAR["cfg_order"]["save_term"]?>일 후에는  자동으로 구매 확정 처리되지만 마일리지/포인트는 소멸됩니다.</li>
<?php }else{?>
				<li>구매 확정을 하시지 않으시더라도 출고 완료 후  <?php echo $TPL_VAR["cfg_order"]["save_term"]?>일 후에는  자동으로 구매 확정 및 마일리지/포인트가 지급됩니다.</li>
<?php }?>
			</ul>
			<ul class="export_buy_confirm_agree_container list_01 v2 C Pt15">
				<li>구매를 확정하기 위해 상품수령을 확인해 주세요.</li>
				<li class="Pt10 gray_01">
					상품을 수령하셨습니까? &nbsp;
					<label><input type="radio" name="export_buy_confirm_agree" value="y" /> 예</label> &nbsp; &nbsp;
					<label><input type="radio" name="export_buy_confirm_agree" value="n" checked /> 아니오</label>
				</li>
			</ul>
		</div>
	</div>
	<div class="layer_bottom_btn_area2">
		<ul class="basic_btn_area2">
			<li><button type="button" id="export_buy_confirm_btn" class="btn_resp size_c color2 Wmax">구매확정</button></li>
			<li><button type="button" class="btn_resp size_c color5" onclick="hideCenterLayer()">취소</button></li>
		</ul>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
</div>

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->

<script type="text/javascript">
function goods_review_write(goodsseq,order_seq){
	if(goodsseq){
<?php if(defined('__ISUSER__')){?>
			window.open( '/mypage/mygdreview_write?goods_seq='+goodsseq+'&order_seq='+order_seq);
<?php }else{?>
			window.open('/board/write?id=goods_review&goods_seq='+goodsseq+'&order_seq='+order_seq);
<?php }?> 
	}
}

$(function() {
	$(".exportbuyconfirm").live('click',function(){
		var export_code = $(this).attr('export_code');
		var status = $(this).attr('status');
		$("#export_buy_confirm_msg input[name='export_code']").val(export_code);
		$("#export_buy_confirm_msg input[name='status']").val(status);

		if(status!='75'){
			$(".export_buy_confirm_agree_container").show();
		}else{
			$(".export_buy_confirm_agree_container").hide();
		}

		// 배송완료 전이면 수령확인 메시지
		//구매 확정 및 마일리지/포인트 지급
		showCenterLayer('#export_buy_confirm_msg');
		//openDialog(getAlert('mp121'), "#export_buy_confirm_msg",{"width":550});
	});

	$("#export_buy_confirm_btn").live("click",function(){
		var ret = false;
		var export_code = $("#export_buy_confirm_msg input[name='export_code']").val();
		var status = $("#export_buy_confirm_msg input[name='status']").val();

		if(status!='75'){
			if(!$("input[name='export_buy_confirm_agree'][value='y']").is(":checked")){
				//상품수령여부에 체크해주세요.
				openDialogAlert(getAlert('mp129'),'450','140',function(){
					$("input[name='export_buy_confirm_agree']").eq(0).focus();
				});
				return;
			}
		}
		hideCenterLayer('#export_buy_confirm_msg');
		//closeDialog("#export_buy_confirm_msg");
		export_buy_confirm(export_code);
	});

	//구매확정처리
	function export_buy_confirm(export_code){
		$.ajax({
			'url' : '../mypage_process/buy_confirm',
			'data' : {'export_code':export_code},
			'type' : 'get',
			'dataType' : 'json',
			'success' : function(data) {
				if(data.result) {
					openDialogAlert(data.msg,'450','200',function(){document.location.reload();});
				}else if(data.msg){
					openDialogAlert(data.msg,'450','200');
				}
			}
		});
	}

});
</script>