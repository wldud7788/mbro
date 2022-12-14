<?php /* Template_ 2.2.6 2022/05/17 12:31:49 /www/music_brother_firstmall_kr/admin/skin/default/goods/excel_upload.html 000014083 */ 
$TPL_logs_1=empty($TPL_VAR["logs"])||!is_array($TPL_VAR["logs"])?0:count($TPL_VAR["logs"]);
$TPL_requires_1=empty($TPL_VAR["requires"])||!is_array($TPL_VAR["requires"])?0:count($TPL_VAR["requires"]);
$TPL_options_1=empty($TPL_VAR["options"])||!is_array($TPL_VAR["options"])?0:count($TPL_VAR["options"]);
$TPL_suboptions_1=empty($TPL_VAR["suboptions"])||!is_array($TPL_VAR["suboptions"])?0:count($TPL_VAR["suboptions"]);
$TPL_inputs_1=empty($TPL_VAR["inputs"])||!is_array($TPL_VAR["inputs"])?0:count($TPL_VAR["inputs"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<style type="text/css">
.upload-form	{ margin-bottom:30px; }
.upload-form .notice {color:red;margin-top:5px;margin-left:35px;}
.input-upload {margin-top:10px;margin-left:35px;}
.
.upload-log {margin-top:40px;width:100%;}
.upload-notice {margin-top:20px;width:100%;}
.excel-upload-table { width:100%;border-top:1px solid #dadada;border-left:1px solid #dadada; }
.excel-upload-table th {border-bottom:1px solid #dadada;border-right:1px solid #dadada; background-color:#f1f1f1;height:28px;line-height:28px;text-align:center;padding:0 5px;}
.excel-upload-table td {border-bottom:1px solid #dadada;border-right:1px solid #dadada;background-color:#ffffff; height:25px;line-height:25px;text-align:left;padding-left:5px;}
.highlight-text {margin-top:15px;font-weight:bold;color:red;}
.amplify-text {margin-top:-8px;font-weight:normal;}
</style>
<script type="text/javascript">
var gl_first_goods_date = '<?php echo $TPL_VAR["config_system"]["first_goods_date"]?>';
<?php if(is_array($TPL_R1=code_load('currency',$TPL_VAR["config_system"]["basic_currency"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
var gl_basic_currency_hangul		= '<?php echo $TPL_V1["value"]["hangul"]?>';
var gl_basic_currency_nation		= '<?php echo $TPL_V1["value"]["nation"]?>';
<?php }}?>

function confirm_first_goods(first_date,currency,hangul,nation,msg,func)
{
	var params = {'yesMsg':'???','noMsg':'?????????'};
	var ph = 180;
	if( !first_date ){
		params = {'yesMsg':'??????','noMsg':'??????'};
		msg = '<div align="left">';
		msg	+= '?????? ??????????????? '+currency+'('+nation+', '+hangul+') ?????????.<br><br>';
		msg	+= '?????? ?????? ?????? ???????????? ???????????? ????????? ??????????????????.<br>';
		msg	+= '??????????????? ???????????? ??????><a href="../setting/multi"><span class="highlight-link">????????????</span></a> ?????? ?????? ??? ????????????.<br>';
		msg	+= '?????? ??????????????? ????????? ??????????????? ???????????? ??? ??????????????? ???????????????<br>';
		msg	+= '??????????????????</div>';
		ph = 250;
	}

	if(msg){
		openDialogConfirm(msg,400,ph,function(){
			eval( func );
		},function(){
		},params);
	}else{
			eval( func );
	}
}

// ????????? ????????? ???
function open_old_excel_upload_next(){
	openDialog("??????????????????/?????? <span class='desc'></span>", "export_upload", {"width":"800","height":"500","show" : "fade","hide" : "fade"});
}

// ????????? ??? submit
function open_old_excel_upload(){
	confirm_first_goods(gl_first_goods_date,gl_basic_currency,gl_basic_currency_hangul,gl_basic_currency_nation,'','open_old_excel_upload_next();');
}

function excel_upload_next()
{
	if	(!$("input#goods_excel_file").val()){
			openDialogAlert('???????????? ????????? ????????????.', 400, 150);
			return false;
		}
		loadingStart();
		$("form#excelUpload").submit();
}

// ????????? ??? submit
function excel_upload(){
	confirm_first_goods(gl_first_goods_date,gl_basic_currency,gl_basic_currency_hangul,gl_basic_currency_nation,'','excel_upload_next();');
}

// log ?????? ????????????
function download_log_file(obj){
	var f	= $(obj).text();
	if	(!f){
		openDialogAlert('?????????????????? ????????????.', 400, 150);
		return false;
	}

	actionFrame.location.replace('../goods_process/download_excel_log?f=' + f);
}

// ?????? sample ?????? ????????????
function download_sample(){
<?php if(serviceLimit('H_AD')){?>
	window.open('https://interface.firstmall.kr/excel_sample/20181011/goodsexcel.admin.sample.xlsx');
<?php }else{?>
	window.open('https://interface.firstmall.kr/excel_sample/20181011/goodsexcel.sample.xlsx');
<?php }?>
}
</script>
<!-- ????????? ????????? ??? : ?????? -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- ????????? -->
		<div class="page-title">
			<h2><span class="icon-goods-kind-goods"></span>?????? ??????????????????/??????</h2>
		</div>

		<!-- ?????? ?????? -->
		<ul class="page-buttons-left">
			<li><span class="btn large"><button type="button" onclick="location.href='catalog';">???????????????</button></span></li>
		</ul>

		<!-- ?????? ?????? -->
		<ul class="page-buttons-right">
			<li><span class="btn large cyanblue"><button type="button" onclick="download_sample();">????????? ???????????? ????????????(??????-Admin)</button></span></li>
			<li><span class="btn large black"><button type="button" onclick="excel_upload();">?????????</button></span></li>
		</ul>
	</div>
</div>
<!-- ????????? ????????? ??? : ??? -->
<div class="upload-form">
	<form name="excelUpload" id="excelUpload" method="post" action="/cli/excel_up/create_goods" enctype="multipart/form-data"  target="actionFrame">
	<input type="hidden" name="goods_kind" value="<?php echo $TPL_VAR["kind"]?>" />
	<div class="item-title">.xlsx ???????????? ????????? ?????? ????????? ??? ???????????? ?????? ??????/?????? </div>
	<div class="input-upload"><input type="file" name="goods_excel_file" id="goods_excel_file" style="height:20px;" /></div>
	
	<div class="notice">[??????] ?????? ?????? ?????? ??? <b>???Excel ?????? ????????? (.xlsx)</b> ??? ??????????????????. ???xlsx??? ????????? ???????????? ???????????????.</div>
	<div class="notice">[??????] ?????? ?????? ??????<?php if(serviceLimit('H_AD')){?>(?????? ????????? ??????)<?php }?> ??????????????? ?????? ????????? ????????? ??? ????????????.</div>
<?php if($TPL_VAR["scm_cfg"]['use']!='Y'){?>
	<div class="notice">
		[??????] '(???) ?????? ????????????'??? ?????? ????????? ????????? <b>'(???) ?????? ??????????????????/??????'</b>?????? ????????? ?????????!
		<span class="btn small cyanblue"><button type="button" onclick="open_old_excel_upload();">(???) ?????? ??????????????????/??????</button></span>
	</div>
<?php }?>
	</form>
</div>

<div class="upload-log">
	<div class="item-title">?????? ?????? (?????? 10???)</div>

	<table class="excel-upload-table" cellpadding="0" cellspacing="0" border="0">
	<colgroup>
		<col width="150" />
		<col width="100" />
		<col />
		<col />
		<col />
	</colgroup>
	<thead>
	<tr>
		<th>?????? ??????</th>
		<th>?????????</th>
		<th>?????????</th>
		<th>????????? ??????</th>
		<th>?????? ??????</th>
		<th>?????? ??????</th>
	</tr>
	</thead>
	<tbody>
<?php if($TPL_logs_1){foreach($TPL_VAR["logs"] as $TPL_V1){?>
	<tr>
		<td><?php echo $TPL_V1["upload_date"]?></td>
		<td><?php echo $TPL_V1["uploader_ip"]?></td>
		<td><?php echo $TPL_V1["uploader"]?></td>
		<td><?php echo $TPL_V1["upload_filename"]?></td>
		<td class="hand" onclick="download_log_file(this);"><?php echo $TPL_V1["result_failed"]?></td>
		<td class="hand" onclick="download_log_file(this);"><?php echo $TPL_V1["result_success"]?></td>
	</tr>
<?php }}else{?>
	<tr>
		<td colspan="6" style="text-align:center;">?????? ????????? ????????????.</td>
	</tr>
<?php }?>
	</tbody>
	</table>
</div>

<div class="upload-notice">
	<div class="item-title red">
		????????? ????????????!  ????????? ??????????????? ????????? ?????????.
		<span class="btn small cyanblue"><button type="button" onclick="download_sample();">????????? ???????????? ????????????(??????-Admin)</button></span>
	</div>

	<table class="excel-upload-table" cellpadding="0" cellspacing="0" border="0">
	<colgroup>
		<col />
	</colgroup>
	<tbody>
	<tr>
		<td>
			<div>1. ????????? ????????? ????????? ??? ????????? = ???????????? ????????? ????????? ??? ????????? ???????????? ??? (???????????? ??? ??? ????????? ???????????? ?????????)</div>
			<br style="line-height:20px;" />

			<div>2. ????????? ????????? ????????? ????????? ?????? ?????? ??? <span class="red"><?php echo count($TPL_VAR["requires"])?></span>???</div>
			<div>- ?????? ??? : <?php if($TPL_requires_1){$TPL_I1=-1;foreach($TPL_VAR["requires"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?>, <?php }?><?php echo $TPL_V1?><?php }}?></div>
			<br style="line-height:20px;" />

			<div>3. ????????? ????????? ?????? ????????? ??????????????? ??? ??? ?????? (?????? ????????? ????????? ????????? ????????? <?php echo count($TPL_VAR["options"])?>??? ?????? ?????? ???????????????)</div>
			<div>- ??????1) ????????? <span class="red"><?php echo count($TPL_VAR["options"])?></span>??? ?????? SET??? ????????? ????????? ???</div>
			<div style="margin-left:13px;font-size:11px;"><?php if($TPL_options_1){$TPL_I1=-1;foreach($TPL_VAR["options"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?>, <?php }?><?php echo $TPL_V1?><?php }}?></div>
			<div>- ??????2) </div>
			<div style="margin-left:13px;">??????????????? ?????? ?????? : ?????????????????? ?????? ?????? ?????????????????? ??? ??? = ????????? ??? ??? = ???????????? ??? ??? = ???????????? ??? ??? = ????????? ??? ??? = ?????????(?????????)??? ??? ??? = ????????? ??? ???</div>
			<div style="margin-left:13px;">??????????????? ?????? ?????? : ?????? 1??? = ????????? 1??? = ????????? 1??? = ?????? 1??? = ?????????(?????????) 1??? = ?????? 1???</div>
			<br style="line-height:20px;" />

			<div>4. ????????? ????????? ???????????? ????????? ??????????????? ??? ??? ?????? (???????????? ????????? ????????? ????????? ????????? <?php echo count($TPL_VAR["suboptions"])?>?????? ?????? ?????? ???????????????)</div>
			<div>- ??????1) ????????? <span class="red"><?php echo count($TPL_VAR["suboptions"])?></span>??? ?????? SET??? ????????? ????????? ???</div>
			<div style="margin-left:13px;font-size:11px;"><?php if($TPL_suboptions_1){$TPL_I1=-1;foreach($TPL_VAR["suboptions"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?>, <?php }?><?php echo $TPL_V1?><?php }}?></div>
			<div>- ??????2)</div>
			<div style="margin-left:13px;">?????????????????? ??? ??? = ?????????????????? ??? ??? = ???????????????????????? ??? ??? = ???????????????????????? ??? ??? = ????????????????????? ??? ??? = ?????????????????????(?????????)??? ??? ??? = ???????????? ????????? ??? ???</div>
			<br style="line-height:20px;" />

			<div>5. ????????? ????????? ?????????????????? ????????? ??????????????? ??? ??? ?????? (?????????????????? ????????? ????????? ????????? ????????? <?php echo count($TPL_VAR["inputs"])?>?????? ?????? ?????? ???????????????)</div>
			<div>- ??????1) ????????? <span class="red"><?php echo count($TPL_VAR["inputs"])?></span>??? ?????? SET??? ????????? ????????? ???</div>
			<div style="margin-left:13px;"><?php if($TPL_inputs_1){$TPL_I1=-1;foreach($TPL_VAR["inputs"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?>, <?php }?><?php echo $TPL_V1?><?php }}?></div>
			<div>- ??????2)</div>
			<div style="margin-left:13px;">???????????????????????? ??? ??? = ??????????????????????????? ??? ???</div>
			<br style="line-height:20px;" />

			<div>6. ?????? ????????? ?????? ???????????? ???????????? ????????? ????????? ?????? ?????? ????????? ?????? ????????? ????????? ???????????? ?????????????????? ???????????? ???????????????. ????????? ????????? ?????? ???????????? ???????????? ???????????? ????????? ?????? ???????????? ?????? ???????????? ???????????????.</div>
			<br style="line-height:20px;" />

			<div>7. ????????? ????????? ?????? ?????? ?????? ????????? ????????? ??????????????? ????????????(?????????,?????????)???, ?????? ????????? ??????????????? ???????????? ????????? ????????? ???????????? ????????? ????????? ????????????.</div>
			<br style="line-height:20px;" />
		</td>
	</tr>
	</tbody>
	</table>
</div>


<div id="export_upload" class="hide">
<form name="excelRegist" id="excelRegist" method="post" action="../goods_process/excel_upload" enctype="multipart/form-data"  target="actionFrame">

	<div class="clearbox"></div>
	<div class="item-title">(???) ?????? ?????? ?????? ??? ??????</div>
	<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="20%" />
		<col width="80%" />
	</colgroup>
	<tr>
		<th class="its-th-align center">????????????</th>
		<td class="its-td">
			<input type="file" name="excel_file" id="excel_file" style="height:20px;"/>
		</td>
	</tr>
	</table>

	<div style="width:100%;text-align:center;padding-top:10px;">
	<span class="btn large cyanblue"><button id="upload_submit">??????</button></span>
	</div>

	<div style="padding:15px;"></div>

	<div style="padding-left:10px;font-size:12px;">
		* ????????? ?????? ??????????????? ????????? ??? ?????? ?????????  ?????? ???????????? ?????? ?????? ???????????? ?????????.<br/>
		&nbsp;&nbsp; ( <span style="color:red;">??????! ???????????? ????????? ???????????? XLS ??? ?????? 97~2003 ???????????? ????????? ?????????</span> ) <br/>
		<div style="padding:3px;"></div>
		* ?????? ????????? ????????? ????????? ????????? ????????? ?????? ?????? ????????? ???????????????.(????????? ????????? ?????? ????????? ??????, ????????? ???????????????.)<br/>
		<div style="padding:3px;"></div>
		* ?????? ????????? ???????????? 1?????? ?????? ???????????????.(????????? ????????? ????????? ????????? ???????????? ????????? ?????? ???????????? ????????????.)<br/>
		<div style="padding:3px;"></div>
		* ?????? ???????????? ???????????? ???????????? ?????? ?????? ?????? ????????? ???????????? ????????????. ?????? ?????? ?????? ????????? ???????????? ???????????? ????????????. <br/>
		<div style="padding:3px;"></div>
		* ????????????????????? ????????????????????? ?????????????????????. ???????????? ????????????????????? ????????????????????? ???????????????.<br/>
		<div style="padding:3px;"></div>
		* ?????????????????? ?????????????????? ?????????????????????. ???????????? ?????????????????? ?????????????????? ???????????????.<br/>
	</div>

	<div style="padding:15px;"></div>


</form>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>