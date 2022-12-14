<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/order/_excel_export.html 000010179 */  $this->include_("scmSelectWarehouse");?>
<style>
	table.excel-export-form-table {border-collapse:collapse;border:1px solid #aaaaaa;}
	table.excel-export-form-table tr th {padding:10px;border-bottom:1px solid #c7c7c7; background-color:#e8e8e8; font-size:14px;color:#000;font-weight:bold;text-align:left;}
	table.excel-export-form-table tr td {padding:10px;border-left:1px solid #dadada;border-bottom:1px solid #dadada;}
	table.excel-export-form-table tr th span.step {font-size:11px;color:#8d8d8d;font-weight:bold;}
	table.excel-export-form-table tr td table.excel-export-info-table {border-collapse:collapse;border:1px solid #aaaaaa;}
	table.excel-export-form-table tr td table.excel-export-info-table tr th {padding:10px;border-left:1px solid #c7c7c7;border-bottom:1px solid #c7c7c7;background-color:#e8e8e8;font-size:11px;color:#000;font-weight:normal;text-align:left;}
	table.excel-export-form-table tr td table.excel-export-info-table tr td {padding:10px;border-left:1px solid #dadada;border-bottom:1px solid #dadada;font-size:11px;}
	table.excel-export-form-table tr td table.excel-export-info-table tr td span.excel-highlight-link{color:#e06d18;text-decoration: underline;}
	table.excel-export-form-table tr td table.export-form-table {border-collapse:collapse;border:2px solid #8fbcec;}
	table.excel-export-form-table tr td table.export-form-table th { padding:5px; border-left:1px solid #8fbcec; font-size:11px; background-color:#f3f8fd; border-bottom:1px solid #8fbcec; }
	table.excel-export-form-table tr td table.export-form-table td { padding:5px; border-left:1px solid #8fbcec;font-size:11px; border-bottom:1px solid #8fbcec;}
	div.attention {font-size:16px;font-weight:bold;}
</style>
<form name="excelRegist" id="excelRegist" method="post" action="../order_process/excel_upload_check" enctype="multipart/form-data"  target="actionFrame" onsubmit="loadingStart();">

<table class="excel-export-form-table" width="100%">
	<col width="140" />
	<col />
	<tr>
		<th>
		<span class="step">STEP 1.</span> ????????????
		</th>
		<td>
			<img src="/admin/skin/default/images/design/img_excel_release.gif" />
		</td>
	</tr>
	<tr>
		<th>
		<span class="step">STEP 2.</span> ??????
		</th>
		<td>
			<table class="excel-export-info-table" width="100%">
			<col width="120" />
			<col />
			<col />
			<tr>
				<th>????????? ???</th>
				<th style="text-align:center;">???????????? ???????????? ?????? ??????</th>
				<th style="text-align:center;">???????????? ???????????? ?????? ??????</th>
			</tr>
			<tr>
				<th>????????????</th>
				<td>
					<div class="attention">?????? ????????? ?????? ??? ????????? ??????????????? ???</div>
					<div class="red">??? ???????????? ??? ?????????????????? ???????????????</div>
				</td>
				<td>
					<div class="attention">?????? ????????? ?????? ??? ????????? ????????????</div>
					<div class="red">??? ???????????? ??? ?????????????????? ???????????? ???0????????? ??? ??? ???????????????</div>
					<div class="red">??? ??????????????? ???????????? ????????? ???????????? ?????????</div>
				</td>
			</tr>
			<tr>
				<th>?????????</th>
				<td>
					<div class="attention">????????? ??????</div>
					<div>??? ??????????????? ????????? ??? ?????? ?????? <span class="excel-highlight-link hand" onclick="view_excel_code_help();">??????)?????????</span></div>
				</td>
				<td>
					<div class="attention">????????? ??????</div>
					<div>??? ??????????????? ????????? ??? ?????? ?????? <span class="excel-highlight-link hand" onclick="view_excel_code_help();">??????)?????????</span></div>
				</td>
			</tr>
			<tr>
				<th>???????????????</th>
				<td>
					<div class="attention">???????????????</div>
					<div>??? ??????????????? ????????? ??? ???????????? ???????????????</div>
					<div>??? ???, ?????????(AUTO) : ?????? ?????? ????????? (???????????????)</div>
					<div>??? ???, ????????????(?????????) : ?????? ?????? ????????? (???????????????)</div>
					<div>??? ???, ????????????(?????????) : ?????? ?????? ????????? (????????? ?????? ??????)</div>
					<div style="margin-left:15px;">??? ?????????????????? ?????? ???</div>
					<div style="margin-left:15px;">??? ???????????? [???????????????/??????] ?????? ???????????? ????????? ?????? ???</div>
					<div style="margin-left:15px;">??? ?????????????????? ?????????</div>
				</td>
				<td>
					<div class="attention">???????????????</div>
					<div>??? ??????????????? ????????? ??? ???????????? ???????????????</div>
					<div>??? ???, ?????????(AUTO) : ?????? ?????? ????????? (???????????????)</div>
					<div>??? ???, ????????????(?????????) : ?????? ?????? ????????? (???????????????)</div>
					<div>??? ???, ????????????(?????????) : ?????? ?????? ????????? (????????? ?????? ??????)</div>
					<div style="margin-left:15px;">??? ?????????????????? ?????? ???</div>
					<div style="margin-left:15px;">??? ???????????? [???????????????/??????] ?????? ???????????? ????????? ?????? ???</div>
					<div style="margin-left:15px;">??? ?????????????????? ?????????</div>
				</td>
			</tr>
			<tr>
				<th>????????????<br/>/??????????????????</th>
				<td>
					<div class="attention">????????????</div>
					<div class="red">??? ??????????????? ??????????????? ???????????? ??????????????? ?????????</div>
				</td>
				<td>
					<div class="attention">??????????????????</div>
					<div class="red">??? ??????????????? ????????????????????? ???????????? ??????????????? ?????????</div>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th>
		<span class="step">STEP 3.</span> ??????
		</th>
		<td>
			????????? ??????????????? .csv ???????????? ??????????????????<br/>
			<br/>
			??? ???????????? : '??????'??? ?????? ??? '?????? ???????????? ??????' ?????? ??? '?????? ??????'??? 'CSV(????????? ??????)' ?????? ??? [??????] ??????<br/>
			??? ???????????? : .csv ????????? ????????? .csv????????? ?????? '????????????'?????? ???????????? ?????? ??????????????? ???????????? ???????????? ????????????.<br/>
			<span style="display:inline-block;width:80px;"></span>????????? ????????? ?????? .xls ????????? ?????? ?????? ??? .csv ????????? ?????? ????????? ????????????.
		</td>
	</tr>

	<tr>
		<th>
		<span class="step">STEP 4.</span> ?????????
		</th>
		<td>
			<div>????????? ????????????(.csv ??????)??? ?????????????????????.</div>
			<div><input type="file" name="excel_file" id="excel_file" /></div>
		</td>
	</tr>

	<tr>
		<th>
		<span class="step">STEP 5.</span> ??????
		</th>
		<td>
			<table class="export-form-table" width="100%">
				<col width="150" />
				<col />
				<tr>
					<th>
						????????????
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
						/ ????????????
<?php }?>
					</th>
					<th>????????????</th>
				</tr>
				<tr>
					<td>
						<input type="text" name="export_date" class="datepicker line"  maxlength="10" size="10" readonly value="<?php echo date('Y-m-d')?>">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
						<?php echo scmSelectWarehouse($TPL_VAR["shopSno"],$TPL_VAR["scmOptions"])?>

<?php }?>
					</td>
					<td>
						<div>
							?????? :
							<span class="hide">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
							<select name="stockable" id="excel_export_stockable" style="width:330px;" onchange="this.options[0].selected=true;">
								<option value="limit">???????????? ?????? ????????? ????????? ?????????</option>
								<option class="gray" value="unlimit">???????????? ?????? ????????? ????????? ????????????</option>
							</select>
<?php }else{?>
							<select name="stockable" id="excel_export_stockable" style="width:330px;">
								<option value="limit">???????????? ?????? ????????? ????????? ?????????</option>
								<option value="unlimit">???????????? ?????? ????????? ????????? ????????????</option>
							</select>
<?php }?>
							??? ?????? ?????? ??? (?????? ???) SMS/EMAIL ?????? ???
							</span>
							<select name="export_step" id="excel_export_step" onchange="check_excel_stock_policy_step();">
								<option value="55">????????????</option>
								<option value="45">????????????</option>
							</select>??? ?????? ??????
							<script>check_excel_stock_policy_step();</script>
						</div>
						<div class="pdt5">
							?????? :
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
							<select name="ticket_stockable" style="width:330px;" onchange="this.options[0].selected=true;">
								<option value="limit">???????????? ?????? ????????? ????????? ?????? ??????????????? ?????????</option>
								<option class="gray" value="limit_ticket">???????????? ?????? ????????? ????????? ???????????? ??????????????? ?????????</option>
							</select>
<?php }else{?>
							<select name="ticket_stockable" style="width:330px;">
								<option value="limit">???????????? ?????? ????????? ????????? ?????? ??????????????? ?????????</option>
								<option value="limit_ticket">???????????? ?????? ????????? ????????? ???????????? ??????????????? ?????????</option>
							</select>
<?php }?>
							??? ?????? ?????? ??? (?????? ???) SMS/EMAIL ?????? ???
							<select name="ticket_step" style="background-color:#efefef;">
								<option value="55">????????????</option>
							</select>??? ?????? ??????
						</div>
					</td>
				</tr>
			</table>

			<div style="width:100%;text-align:center;padding-top:10px;" id="upload_submit_layer">
				<span class="btn large cyanblue">
					<button type="submit" id="upload_submit" style="width:150px;">
						???????????? ??????
					</button>
				</span>
			</div>
			<div style="width:100%;text-align:center;padding-top:10px;" id="upload_information_layer" class="hide">
				<span class="red bold">??????????????? ????????? ?????????...</span>
			</div>
		</td>
	</tr>
</table>
</form>

<div class="center pdt10">
<span class="btn small gray">
	<button type="button" onclick="closeDialog('export_upload');reset_iframe('','');">?????????</button>
</span>
</div>