<?php /* Template_ 2.2.6 2022/05/17 12:29:06 /www/music_brother_firstmall_kr/selleradmin/skin/default/export/batch_status_popup.html 000006326 */ ?>
<form method="post" action="../export_process/batch_status" target="export_frame" onsubmit="loadingStart();">
		<input type="hidden" name="codes" value="<?php echo $_GET["codes"]?>">
		<input type="hidden" name="export_date" value="<?php echo $_GET["export_date"]?>">
		<input type="hidden" name="market_mode" value="<?php echo $_GET["market_mode"]?>">
		<input type="hidden" name="err_codes" value="<?php echo $_GET["err_export_code"]?>">

<?php if($_GET["market_mode"]=='y'){?>
		<table class="export_table" style="border-collapse:collapse" border='1'>
		<col width="120" />
		<col />
		<tr>
			<th>처리결과</th>
			<td>
				송장전송 <?php echo number_format($_GET["req_cnt"])?>건 요청
			</td>
		</tr>
		<tr>
			<th>성공</th>
			<td>
				<?php echo number_format($_GET["req_cnt"]-$_GET["err_cnt"])?> 건
			</td>
		</tr>
		<tr>
			<th>실패 <span title="실패안내" class="helpicon2" onclick="view_market_export_fail();"></span></th>
			<td>
				<?php echo number_format($_GET["err_cnt"])?> 건 <?php if($_GET["err_cnt"]> 0){?><span class="btn small orange"><button onclick="view_market_export_code();" type="button">내역확인</button></span><?php }?>
			</td>
		</tr>
<?php if($_GET["err_cnt"]> 0){?>
		<tr>
			<th>실패상품처리</th>
			<td>
				<label class="search_label" style="display:inline-block;padding:3px 3px 3px 0px;width:90px;">
					<input type="radio" name="status" value="55" checked />배송중 처리</label>
				</label>
				<label class="search_label" style="display:inline-block;padding:3px 3px 3px 0px;width:90px;">
					<input type="radio" name="status" value="65" />배송완료 처리</label>
				</label>
			</td>
		</tr>
		</table>
		<div class="center mt10">
			<table border="0" align="center" style="width:100%">
				<tr>
					<td><span class="btn large cyanblue" ><button type="submit">처리</button></span></td>
				</tr>
			</table>
		</div>
<?php }else{?>
		<div class="center mt20">
			<table border="0" align="center" style="width:100%">
				<tr>
					<td class="center"><span class="btn large cyanblue center" ><button type="button" onclick="location.reload();">확인</button></span></td>
				</tr>
			</table>
		</div>
<?php }?>
<?php }else{?>
		<input type="hidden" name="status" value="<?php echo $_GET["mode"]?>">
		<table class="export_table" style="border-collapse:collapse" border='1'>
		<col width="120" />
		<col />
		<tr>
			<th>처리결과</th>
			<td>
<?php if($_GET["req_cnt"]){?>
				<?php echo $TPL_VAR["status_title"][$_GET["mode"]+ 10]?> <?php echo number_format($_GET["req_cnt"])?>건 요청 → 성공 <?php echo number_format($_GET["req_cnt"]-$_GET["err_cnt"])?>건 ,실패 <?php echo number_format($_GET["err_cnt"])?>건
<?php }else{?>
				출고준비 <?php echo number_format($_GET["cnt_export_request_45"])?>건 요청 → 성공 <?php echo number_format($_GET["cnt_export_result_goods_45"])?>건 ,실패 <?php echo number_format($_GET["cnt_export_error_45"])?>건<br/>
				출고완료 <?php echo $_GET["cnt_export_request_55"]?>건 요청 → 성공 <?php echo number_format($_GET["cnt_export_result_coupon_55"]+$_GET["cnt_export_result_goods_55"])?>건 ,실패 <?php echo number_format($_GET["cnt_export_error_55"])?>건
<?php }?>
			</td>
		</tr>
<?php if($_GET["mode"]=='45'){?>
		<tr>
			<th>출고처리</th>
			<td>
				<div class="pdb5">
					실물 :
					<input type="hidden" name="stockable" id="export_stockable" value="<?php echo $TPL_VAR["data_present_provider"]["default_export_stock_check"]?>">
					<span class="hide">
<?php if($TPL_VAR["data_present_provider"]["default_export_stock_check"]=='limit'){?>
					출고되는 모든 실물의 재고가 있으면
<?php }elseif($TPL_VAR["data_present_provider"]["default_export_stock_check"]=='unlimit'){?>
					출고되는 모든 실물의 재고가 부족해도
<?php }?>
					→ 재고 차감 → (설정 시) SMS/EMAIL 발송 →
					</span>
					출고완료
					로 상태 처리
				</div>
			</td>
		</tr>
<?php }?>
<?php if($_GET["export_result_error_msg"]){?>
		<tr>
			<th>실패사유</th>
			<td>
				<div class="pdb5"><span class="red"><?php echo $_GET["export_result_error_msg"]?></span></div>
			</td>
		</tr>
<?php }?>
<?php if($_GET["export_result_msg"]){?>
		<tr>
			<th>메세지</th>
			<td>
				<div class="pdb5"><span class="red"><?php echo $_GET["export_result_msg"]?></span></div>
			</td>
		</tr>
<?php }?>
		</table>
		<div class="center pdt5">
<?php if($_GET["mode"]=='45'){?>
			<div class="red pdb5 fx11">통신판매중계자가 입점사 판매상품을 출고처리 시 그에 따른 책임을 통신판매중계자에게 있습니다.</div>
<?php }?>
			<table border="0" align="center">
				<tr>
					<td><span class="btn large red" ><button type="button" onclick="printExportView('','<?php echo $_GET["codes"]?>')">출고목록 인쇄</button></span></td>
<?php if($_GET["mode"]=='45'){?>
					<td>&nbsp;&nbsp;</td>
					<td><span class="btn large cyanblue" ><button type="submit">계속 출고완료 처리</button></span></td>
<?php }?>
				</tr>
			</table>
		</div>
<?php }?>
</form>

<div id="market_export_fail" style="display:none;">
기사용된 송장번호, 유효하지 않은 송장번호, <br/>
오픈마켓에서 취소/반품/교환 요청 등의 사유로 실패처리됨
</div>

<div id="market_export_code" style="display:none;">
※ 실패사유는 [주문상세>처리내역]에서 확인 가능
<table class="info-table-style" class="info-table-style" style="width:100%">
	<colgroup>
		<col width="25%" />
		<col width="75%" />
	</colgroup>
	<thead>
	<tr>
		<th class="its-th-align center">순번</th>		
		<th class="its-th-align center">출고번호</th>
	</tr>
	</thead>
	<tbody>
<?php if(is_array($TPL_R1=explode('|',$_GET["err_export_code"]))&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
	<tr>
		<td class="its-td-align center"><?php echo ($TPL_I1)+ 1?></td>		
		<td class="its-td-align center"><?php echo $TPL_V1?></td>	
	</tr>
<?php }}?>
	</tbody>
</table>
<br/><br/>
</div>