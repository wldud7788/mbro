<?php /* Template_ 2.2.6 2022/05/17 12:36:55 /www/music_brother_firstmall_kr/admin/skin/default/setting/bank.html 000011176 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL_loop2_1=empty($TPL_VAR["loop2"])||!is_array($TPL_VAR["loop2"])?0:count($TPL_VAR["loop2"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/jquery/jquery.tablednd.js"></script>

<script type="text/javascript">
	/* 계좌 사용여부에 따라 배경색상 변경 */
	function set_tr_bgcolor(){
		var obj = $(".table_01 tbody tr");
		obj.css("background-color","#ffffff");
		obj.find("select[name='accountUse[]'] option[value='y']:selected").parent().parent().parent().css("background-color", "#fff");
		
		$(".tablednd").tableDnD({onDragClass:"dragRow"});		
	}

	$(document).ready(function() {	

		/* 계좌 사용여부에 따라 배경색상 변경 */
		$(".table_01 tbody tr select[name='accountUse[]'], .table_01 tbody tr select[name='accountUseReturn[]']").live("change",function(){
			set_tr_bgcolor();			
		});

		/* 계좌추가 */
		$("#addBank").live("click",function(){
<?php if($TPL_VAR["isdemo"]["isdemo"]){?>
				<?php echo $TPL_VAR["isdemo"]["isdemojs2"]?>

<?php }else{?>

			var obj = $("#bankTable tbody tr").eq(0).clone();
			obj.find("input").val("");
			obj.find("select option").eq(0).attr("selected",true);
			$("#bankTable tbody").append(obj);
			/* 인풋박스 타이틀 표기 */
			setDefaultText();
			/* 계좌 사용여부에 따라 배경색상 변경 */
			set_tr_bgcolor();
<?php }?>
		});

		/* 계좌삭제 */
		$("#bankTable tbody tr .removeBank").live("click",function(){
<?php if($TPL_VAR["isdemo"]["isdemo"]){?>
				<?php echo $TPL_VAR["isdemo"]["isdemojs2"]?>

<?php }else{?>	

			if($("#bankTable tbody tr .removeBank").length > 1){
				$(this).parent().parent().remove();
			}else{
				$(this).parent().parent().find("input").val("");
				$(this).parent().parent().find("select option").eq(0).attr("selected",true);
				/* 인풋박스 타이틀 표기 */
				setDefaultText();
				/* 계좌 사용여부에 따라 배경색상 변경 */
				set_tr_bgcolor();
			}
<?php }?>
		});

		/* 반품배송비 입금계좌추가 */
		$("#addBankReturn").live("click",function(){
<?php if($TPL_VAR["isdemo"]["isdemo"]){?>
				<?php echo $TPL_VAR["isdemo"]["isdemojs2"]?>

<?php }else{?>

			var obj = $("#bankReturnTable tbody tr").eq(0).clone();
			obj.find("input").val("");
			obj.find("select option").eq(0).attr("selected",true);
			$("#bankReturnTable tbody").append(obj);
			/* 인풋박스 타이틀 표기 */
			setDefaultText();
			/* 계좌 사용여부에 따라 배경색상 변경 */
			set_tr_bgcolor();

<?php }?>
		});

		/* 반품배송비 입금계좌삭제 */
		$("#bankReturnTable tbody tr .removeBankReturn").live("click",function(){
<?php if($TPL_VAR["isdemo"]["isdemo"]){?>
				<?php echo $TPL_VAR["isdemo"]["isdemojs2"]?>

<?php }else{?>

			if($("#bankReturnTable tbody tr .removeBankReturn").length > 1){
				$(this).parent().parent().remove();
			}else{
				$(this).parent().parent().find("input").val("");
				$(this).parent().parent().find("select option").eq(0).attr("selected",true);
				/* 인풋박스 타이틀 표기 */
				setDefaultText();
				/* 계좌 사용여부에 따라 배경색상 변경 */
				set_tr_bgcolor();
			}

<?php }?>
		});

		$("#autodeposit_request").click(function(){
			$.get('bank_payment', function(data) {
				$('#popup').html(data);
				openDialog("자동입금 신청 <span class='desc'>&nbsp;</span>", "popup", {"width":"800","height":"630"});
			});
		});

		$("#autodeposit_list").click(function(){
			$.get('bank_history', function(data) {
				$('#popup').html(data);
				openDialog("자동입금 서비스 신청 내역 <span class='desc'>&nbsp;</span>", "popup", {"width":"800","height":"550"});
			});
		});

		set_tr_bgcolor();
	});
</script>
<style type="text/css">
	.simplelist-table-style thead th {padding:3px 0;}
</style>
<form name="pgSettingForm" method="post" enctype="multipart/form-data" action="../setting_process/bank" target="actionFrame">

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
<?php $this->print_("require_info",$TPL_SCP,1);?>

	
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>무통장</h2>
		</div>

		<!-- 우측 버튼 -->
		<div class="page-buttons-right">
			<button class="resp_btn active2 size_L" type="submit">저장</button></span>
		</div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<div class="contents_container">
	<!-- 서브메뉴 바디 : 시작-->
	<div class="contents_dvs">
		<div class="item-title">
			무통장 입금 수단	
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/bank', '#tip1')"></span>
		</div>					

		<table id="bankTable" class="table_basic tdc tablednd" >
			<colgroup>
				<col width="5%" />
				<col width="25%" />
				<col width="25%" />
				<col width="25%" />
				<col width="10%" />
				<col width="10%" />
			</colgroup>
			<thead>
				<tr class="nodrag nodrop">
					<th>순서</th>
					<th>은행</th>
					<th>예금주</th>
					<th>계좌번호</th>
					<th>사용 여부</th>
					<th><button type="button" class="btn_plus" id="addBank"></button></th>
				</tr>
			</thead>
		
			<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<tr>
				<td><img src="/admin/skin/default/images/common/icon_move.png"></td>
				<td>
					<select name="bank[]">
<?php if(is_array($TPL_R2=code_load('bankCode'))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["codecd"]==$TPL_V1["bank"]){?>
						<option value='<?php echo $TPL_V2["codecd"]?>' selected><?php echo $TPL_V2["value"]?></option>
<?php }else{?>
						<option value='<?php echo $TPL_V2["codecd"]?>'><?php echo $TPL_V2["value"]?></option>
<?php }?>
<?php }}?>
					</select>
				</td>
				<td>
					<input type="text" name="bankUser[]" class="line" title="예금주" size="30" value="<?php echo $TPL_V1["bankUser"]?>"/>
				</td>
				<td>
					<input type="text" name="account[]" class="line" title="계좌번호" size="30" value="<?php echo $TPL_V1["account"]?>"/>
				</td>
				<td>
					<select name="accountUse[]">
<?php if($TPL_V1["accountUse"]=='n'){?>
						<option value="y">사용</option>
						<option value="n" selected>미사용</option>
<?php }else{?>
						<option value="y" selected>사용</option>
						<option value="n">미사용</option>
<?php }?>
					</select>
				</td>
				<td>							
					<button type="button" class="removeBank btn_minus"></button>							
				</td>
			</tr>
<?php }}?>
			</tbody>
		</table>
	</div>

	<div class="contents_dvs">
		<div class="item-title">
			반품배송비 입금계좌
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/bank', '#tip2')"></span>
		</div>	

		<table id="bankReturnTable" class="table_basic tdc tablednd">
			<colgroup>
				<col width="5%" />
				<col width="25%" />
				<col width="25%" />
				<col width="25%" />
				<col width="10%" />
				<col width="10%" />
			</colgroup>
			<thead>
				<tr class="nodrag nodrop">
					<th>순서</th>
					<th>은행</th>
					<th>예금주</th>
					<th>계좌번호</th>
					<th>사용 여부</th>
					<th><button type="button" id="addBankReturn" class="btn_plus"></button></th>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_loop2_1){foreach($TPL_VAR["loop2"] as $TPL_V1){?>
				<tr>
					<td><img src="/admin/skin/default/images/common/icon_move.png"></td>
					<td>
						<select name="bankReturn[]">
<?php if(is_array($TPL_R2=code_load('bankCode'))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["codecd"]==$TPL_V1["bankReturn"]){?>
							<option value='<?php echo $TPL_V2["codecd"]?>' selected><?php echo $TPL_V2["value"]?></option>
<?php }else{?>
							<option value='<?php echo $TPL_V2["codecd"]?>'><?php echo $TPL_V2["value"]?></option>
<?php }?>
<?php }}?>
						</select>
					</td>
					<td>
						<input type="text" name="bankUserReturn[]" class="line" title="예금주" size="30" value="<?php echo $TPL_V1["bankUserReturn"]?>"/>
					</td>
					<td>
						<input type="text" name="accountReturn[]" class="line" title="계좌번호" size="30" value="<?php echo $TPL_V1["accountReturn"]?>"/>
					</td>
					<td>
						<select name="accountUseReturn[]">
							<option value="y" <?php if($TPL_V1["accountUseReturn"]=='y'){?> selected <?php }?>>사용</option>
							<option value="n" <?php if($TPL_V1["accountUseReturn"]=='n'||$TPL_V1["accountUseReturn"]==''){?> selected <?php }?>>미사용</option>
						</select>
					</td>
					<td>								
						<button type="button" class="removeBankReturn btn_minus"></button>								
					</td>
				</tr>
<?php }}?>
			</tbody>
		</table>
	</div>

	<div class="item-title">무통장 자동 입금 확인</div>			
	<div class="box_style_02">				
		자동입금확인은 약 1시간마다 수집한 은행의 입금내역을 매시 20분마다 주문내역과 매칭함으로써 자동으로 입급확인이 이루어 집니다.<br/>
		매시 20분마다 실행되는 입금내역과 주문내역의 매칭 작업은 수동으로 실행하실 수도 있습니다.<br/><br/>
<?php if($TPL_VAR["autodeposit_status"]=='S'){?>
		서비스 신청을 하셨습니다.<br/>  
<?php if($TPL_VAR["status_code"]== 0){?>
		입금대기중입니다. 입금을 해주시길 바랍니다. (마이퍼스트몰에서 결제 가능)
<?php }else{?>
		서비스 설치대기 상태입니다. 자세한 문의는 퍼스트몰 고객센터 1544-3270 으로 해주시길 바랍니다.
<?php }?>
<?php }else{?>
			무통장 입금 주문건에 대하여 자동으로 입금확인이 되고자 하시면 서비스를 신청해 주세요.
	
			<div class="center mt10">
<?php if($TPL_VAR["bankChk"]=='Y'||$TPL_VAR["bankChk"]=='END'){?>
				<button type="button" id="autodeposit_request" class="btn_resp b_gray size_a mr10">연장신청</button>
				<button type="button" id="autodeposit_list" class="btn_resp b_gray size_a ">서비스 내역</button>
<?php }else{?>
				<button type="button" class="resp_btn active size_L" <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> id="autodeposit_request"<?php }?>>신청</button>							
<?php }?>
			</div>
<?php }?>				
	</div>

<?php if($TPL_VAR["bankChk"]=='Y'){?>
	<div class="clearbox">
	<div style="width:98%;padding-left:15px;">
		<iframe style="width:100%; height:800px;" src="https://bankda.firstmall.kr:7443/?cid=<?php echo $TPL_VAR["cid"]?>" frameborder="0"></iframe>
	</div>
	</div>
<?php }?>		
	<!-- 서브메뉴 바디 : 끝 -->
</div>
<!-- 서브 레이아웃 영역 : 끝 -->

<div id="popup" class="hide"></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>