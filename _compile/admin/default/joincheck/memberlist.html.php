<?php /* Template_ 2.2.6 2020/12/29 17:19:51 /www/music_brother_firstmall_kr/admin/skin/default/joincheck/memberlist.html 000012852 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=20200601"></script>
<style>
.goods_name {display:inline-block;white-space:nowrap;overflow:hidden;width:290px;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
.search_label 	{display:inline-block;width:100px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
span.step_title { font-weight:normal;padding-right:5px }
</style>
<script type="text/javascript">
$(document).ready(function() {

	gSearchForm.init({'pageid':'joincheck_memberlist','search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>'});

	$(".all-check").toggle(function(){
		$(this).parent().find('input[type=checkbox]').attr('checked',true);	
	},function(){
		$(this).parent().find('input[type=checkbox]').attr('checked',false);
	});
	

	$("select.list-select").bind("change",function(){
		var value_str = $(this).val();
		if( value_str ){
			$(".chk").attr("checked",false).change();	
		
			if( value_str=='select' ){
				$(".chk").attr("checked",true).change();			
			}
		}
	});
	
	
<?php if($TPL_VAR["rc"]["check_SMS"]){?>
	var str = "<?php echo $TPL_VAR["rc"]["check_SMS"]?>";		
	$(".sms_byte").html(chkByte(str));
<?php }?>
	
	$(".board_sms_contents").live("keyup",function(){
		str = $(this).val();
		$(this).parent().parent().parent().find(".sms_byte").html(chkByte(str));
	});

	
	$(".paySMS").on("click",function(){


		$('#ReviewEmoneytPopup')[0].reset();
		
		var jcresult_seq = new Array();
		
		$("input[name='jcresult_seq[]']:checked").each(function(){
			jcresult_seq.push($(this).val());
		});		
		
		var mcount = jcresult_seq.length;
		//alert(arrCheckedMemberSeq.join(","));
		if(mcount > 0){
			var mid = $("input[name='jcresult_seq[]']:checked").eq(0).attr('userid');
			$('#emoney_mid').val(mid);		
			$('#j_seq').val(jcresult_seq);
			if(mcount == 1){
				$('#mbname').html(mid);
			}else{
				$('#mbname').html(mid + " ???  " + (mcount-1) + " ???");
			}
			openDialog("????????????", "ReviewEmoneytlayList", {"width":"600","height":"500","show" : "fade","hide" : "fade"});
		}else{
			alert('????????? ????????? ????????? ?????? ????????? ?????????.');
			return false;
		}
	});
	
	/* ????????? ????????? ?????? */
	$("button.review_emoneyt_btn").live("click",function(){
		$('#ReviewEmoneytPopup')[0].reset();
						
		var userid = $(this).attr('userid');		
		var jcresult= $(this).attr('jcresult_seq');
		
		$('#j_seq').val(jcresult);
		$('#emoney_mid').val(userid);
		$('#mbname').html(userid);
		openDialog("????????????", "ReviewEmoneytlayList", {"width":"600","height":"500","show" : "fade","hide" : "fade"});
	});
	
	/* ????????? ????????? ?????? */
	$("button#emoney_pay_cancel").live("click",function(){
		$('#ReviewEmoneytlayList').dialog('close');
	});
	
	$('#ReviewEmoneytPopup').validate({
		onkeyup: false,
		rules: {
			emoney_pay_memo: { required:true},
			emoney_pay_emoney: { required:true, number: true},
		},
		messages: {
			emoney_pay_memo: { required:'????????? ?????????.'},
			emoney_pay_emoney: { required:'????????? ?????????.'}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent());
		},
		submitHandler: function(f) {			
				if( !$(".board_sms_contents").val() ) {
					$(".board_sms_contents").focus();
					return false;			
			}
			f.submit();
		}
	});
	
});

	function set_date(start,end){	
		$("input[name='sdate']").val(start);
		$("input[name='edate']").val(end);
	}
	
	function jc_copy_btn(seq){	
		var str="../joincheck_process?mode=joincheck_copy&joincheck_seq=" + seq;
		$("iframe[name='actionFrame']").attr('src',str);
	}
	
	function jc_delete_btn(seq){
		var str="../joincheck_process?mode=joincheck_delete&joincheck_seq=" + seq;
		$("iframe[name='actionFrame']").attr('src',str);
		
	}

	
	// ????????? byte??? ?????? ????????? ????????????
	function chkByte(str){
		var cnt = 0;
		for(i=0;i<str.length;i++) {
			cnt += str.charCodeAt(i) > 128 ? 2 : 1;
		}
		return cnt;
	}
	
	function emoneyclose(){
		document.location.reload();
	}
	
</script>

<!-- ????????? ????????? ??? : ?????? -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		
		<!-- ????????? -->
		<div class="page-title">
			<h2>?????? ?????? ??????</h2>
		</div>
		<!-- ?????? ?????? -->
		<ul class="page-buttons-left hide">
			<li><span class="btn large white"><button type="button" onclick="document.location.href='/admin/joincheck/catalog?<?php echo $TPL_VAR["query_string"]?>';">?????????????????????<span class="arrowright"></span></button></span></li>				
		</ul>
	</div>
</div>
<!-- ????????? ????????? ??? : ??? -->

<!-- ???????????? ????????? ????????? : ?????? -->
<div id="search_container" class="search_container v2">
<form name="searchForm" id="searchForm"  >
<input type="hidden" name="joincheck_seq" value="<?php echo $TPL_VAR["sc"]["joincheck_seq"]?>" cannotBeReset=1 />

	<table class="table_search">
	<tr>
			<th>????????????</th>
			<td><?php echo $TPL_VAR["rc"]["title"]?></td>
		</tr>
		<tr>
			<th>?????????</th>
		<td>
				<select name='serach_field' class="resp_select">
					<option value=''>??????</option>
					<option value='mem.user_name' <?php if($TPL_VAR["sc"]["serach_field"]=='mem.user_name'){?>selected<?php }?>>??????</option>
					<option value='mem.userid' <?php if($TPL_VAR["sc"]["serach_field"]=='mem.userid'){?>selected<?php }?>>?????????</option>
				</select>
				<input type="text" name="keyword" value="<?php echo htmlspecialchars($TPL_VAR["sc"]["keyword"])?>" size="80"/>
		</td>
	</tr>
			<tr>
				<th>??????</th>
				<td>				
				<div class="resp_radio">					
					<label><input type="radio" name="clear_success[]" value="all" checked/> ??????</label>
					<label><input type="radio" name="clear_success[]" value="N" <?php if($TPL_VAR["sc"]["clear_success"]&&in_array('N',$TPL_VAR["sc"]["clear_success"])){?>checked<?php }?>/> ?????????</label>
					<label><input type="radio" name="clear_success[]" value="Y" <?php if($TPL_VAR["sc"]["clear_success"]&&in_array('Y',$TPL_VAR["sc"]["clear_success"])){?>checked<?php }?>/> ??????</label>			
				</div>
				</td>
			</tr>
			<tr>
				<th>??????</th>
				<td>				
				<div class="resp_radio">
					<label><input type="radio" name="emoney_pay[]" value="all" checked/> ??????</label>
					<label><input type="radio" name="emoney_pay[]" value="N" <?php if($TPL_VAR["sc"]["emoney_pay"]&&in_array('N',$TPL_VAR["sc"]["emoney_pay"])){?>checked<?php }?>/> ?????????</label>
					<label><input type="radio" name="emoney_pay[]" value="Y" <?php if($TPL_VAR["sc"]["emoney_pay"]&&in_array('Y',$TPL_VAR["sc"]["emoney_pay"])){?>checked<?php }?>/> ??????</label>	
				</div>
		</td>
	</tr>
	</table>
	<div class="search_btn_lay center mt10 footer"></div>
</div>
<!-- ???????????? ????????? ????????? : ??? -->
</form>

<div class="contents_container">
	<!-- ???????????? ????????? ????????? : ?????? -->
	<div class="list_info_container">
		<div class="dvs_left">			
			<div class="left-btns-txt">
				?????? <strong><?php echo number_format($TPL_VAR["sc"]["searchcount"])?></strong>??? (??? <strong><?php echo number_format($TPL_VAR["sc"]["totalcount"])?></strong>???)
				- ?????? <?php echo $TPL_VAR["sc"]["totalcount"]?>

				/ ?????? <?php echo $TPL_VAR["rc"]["sum_clear"]?>

				/ ?????? <?php echo $TPL_VAR["rc"]["sum_emoney"]?>

			</div>			
		</div>
	</div>
	
	<div class="table_row_frame">	
		<div class="dvs_top">	
			<div class="dvs_left">
			<button name="paySMS" class="paySMS resp_btn active">?????? ?????? ?????? ??????</button>
			</div>
		</div>
	
<form name='joinchecklist' id='joinchecklist' method='POST' >
	<table class="table_row_basic">
	<!-- ????????? ?????? : ?????? -->
	<colgroup>
		<col width="7%" />
		<col width="7%" />
		<col width="14%" />
		<col width="14%" />
		<col width="15%" />
		<col width="15%" />
		<col width="15%" />
		<col width="13%" />
	</colgroup>
	<thead class="lth">
	<tr>
		<th><label class="resp_checkbox"><input type="checkbox" class="allChkEvent" name="all_chk"/></label></th>
		<th>??????</th>
		<th>?????????</th>
		<th>??????</th>
		<th>????????????</th>
		<th>????????????</th>
		<th>?????? ??????</th>
		<th>?????? ??????</th>
	</tr>
	</thead>
	<!-- ????????? ?????? : ??? -->

	<!-- ????????? : ?????? -->
	<tbody>
<?php if($TPL_VAR["record"]){?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
	<!-- ???????????? ?????????(??????????????? ??? ??????) : ?????? -->
	<tr>
		<td><label class="resp_checkbox"><input type="checkbox" class="chk" name="jcresult_seq[]" value="<?php echo $TPL_V1["jcresult_seq"]?>" userid="<?php echo $TPL_V1["userid"]?>" /></label></td>			
		<td><?php echo $TPL_V1["_no"]?></td>
		<td><span class='hand blue' onclick="open_crm_summary(this,'<?php echo $TPL_V1["member_seq"]?>','','right');" style="cursor: pointer;"><?php echo $TPL_V1["userid"]?></span></td>
		<td><span class='hand blue'  onclick="open_crm_summary(this,'<?php echo $TPL_V1["member_seq"]?>','','right');" style="cursor: pointer;"><?php echo $TPL_V1["user_name"]?></span></td>
		<td><?php echo $TPL_V1["usercount"]?>???</td>
		<td><?php echo $TPL_V1["mclear_success"]?></td>
		<td><?php if($TPL_V1["memoney"]!='?????????'){?><?php echo get_currency_price($TPL_V1["memoney"], 2)?><?php }else{?><?php echo $TPL_V1["memoney"]?><?php }?></td>
		<td>
<?php if($TPL_V1["emoney_pay"]=='N'){?>
				<button type="button"  name="review_emoneyt_btn" mbname="<?php echo $TPL_V1["user_name"]?>"  userid="<?php echo $TPL_V1["userid"]?>"  jcresult_seq="<?php echo $TPL_V1["jcresult_seq"]?>" member_seq="<?php echo $TPL_V1["member_seq"]?>" class="review_emoneyt_btn resp_btn v2">??????</button>
<?php }else{?> - <?php }?>
		</td>
	</tr>
	<!-- ?????????????????? : ??? -->
<?php }}?>
<?php }else{?>
	<!-- ??????????????????(??????????????? ??? ??????) : ?????? -->
	<tr>
		<td colspan="8">
<?php if($TPL_VAR["keyword"]){?>
				'<?php echo $TPL_VAR["keyword"]?>' ????????? ????????? ????????????.
<?php }else{?>
				????????? ????????? ????????????.
<?php }?>
		</td>
	</tr>
	<!-- ?????????????????? : ??? -->

<?php }?>
	</tbody>
	<!-- ????????? : ??? -->

</table>
<!-- ???????????? ????????? ????????? : ??? -->
</form>
		<div class="dvs_bottom">
			<div class="dvs_left">
				<button name="paySMS" class="paySMS resp_btn active">?????? ?????? ?????? ??????</button>
			</div>
		</div>
	</div>
</div>

<!-- ????????? -->
<div class="paging_navigation mt30"><?php echo $TPL_VAR["pagin"]?></div>



<div id="ReviewEmoneytlayList" class="hide">
<form name="ReviewEmoneyPopup" id="ReviewEmoneytPopup" method="post" action="../joincheck_process/emoney_pay" target="actionFrame">
<input type="hidden" name="mode" id="mode" value="emoney_pay" />
<input type="hidden" name="joincheck_seq" id="joincheck_seq" value="<?php echo $_GET["joincheck_seq"]?>" />
<input type="hidden" name="jcresult_seq" id="j_seq" value="" />
<input type="hidden" name="mid" id="emoney_mid" value="<?php echo $TPL_VAR["mid"]?>" />
<input type="hidden" name="mseq" id="emoney_mseq" value="<?php echo $TPL_VAR["mseq"]?>" />

		<div class="item-title mt2">?????? ?????? ??????</div>

		<table class="table_basic thl">			
		<tr>
				<th>????????????</th>
				<td id="mbname"></td>
		</tr>
		<tr>
				<th>????????????</th>
				<td>
					???????????? ?????????
					<!--<input type="text" name="emoney_pay_memo"  id="emoney_pay_memo"  size="40" value="???????????? ????????? ??????" title=""  class="resp_text" />-->
				</td>
		</tr>
		<tr>
				<th>?????????</th>
				<td>
					<input type="text" name="emoney_pay_emoney"  id="emoney_pay_emoney"  size="10" value="" title="" class="resp_text right" />
					<?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

				</td>
		</tr>

		<tr>
				<th>SMS </th>
				<td>
					<label class='resp_checkbox'><input type="checkbox" name="send_sms" id="send_sms" value="1" /> SMS ?????? [?????? SMS ?????? : 100???]</label>
					<textarea name="emoney_pay_sms" cols="40" rows="5" class="board_sms_contents" class="resp_textarea"><?php echo $TPL_VAR["rc"]["check_SMS"]?></textarea>
					<div class="byte_info"><span class="sms_byte">0</span>bytes</div>
			</td>
		</tr>
			
		</table>
		
		<div class="footer">	
			<button type="submit" id="emoney_pay_save" class="resp_btn active size_XL" >??????</button>
			<button type="button" id="emoney_pay_cancel" class="resp_btn v3 size_XL" onclick="$('#ReviewEmoneytlayList').dialog('close');">??????</button>
		</div>
</form>
</div>

<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>