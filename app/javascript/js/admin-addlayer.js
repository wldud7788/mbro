// 항목 추가 함수

var label_item_seq = 0;

$(document).ready(function() {
	var layer_seq = 0;
	var label_maxid = $("input[name=Label_maxid]").val();
	if(label_maxid){
		layer_seq = label_maxid;
	}	
	
	$(".labelList").sortable({axis: 'y'});

	$(".sample").hide();

	$("#joinBtn").click(function(){
	
		resetLabel();
		joinDivShow();
	});

	if(!$('body').data('listJoinBtnEventBinded')){
		
		$("body").on("click",".listJoinBtn",function(){
			$('body').data('listJoinBtnEventBinded',true);	
			resetLabel();
			joinDivShow();
	
			var seq			= 	$(this).attr('value');			
			var join_type	= 	$(this).attr('join_type');
			if(join_type=='user'){
			var labelName	=	$('input[name="labelItem[user]['+seq+'][name]"]').val();
			var labelType	=	$('input[name="labelItem[user]['+seq+'][type]"]').val();
			var labelExp	=	$('input[name="labelItem[user]['+seq+'][exp]"]').val();
			var labelValue	=	$('input[name="labelItem[user]['+seq+'][value]"]').val().split("|");
			}else if(join_type=='order'){
			var labelName	=	$('input[name="labelItem[order]['+seq+'][name]"]').val();
			var labelType	=	$('input[name="labelItem[order]['+seq+'][type]"]').val();
			var labelExp	=	$('input[name="labelItem[order]['+seq+'][exp]"]').val();
			var labelValue	=	$('input[name="labelItem[order]['+seq+'][value]"]').val().split("|");	
			}
			var vallength = labelValue.length - 1;
			var i = 0;
			var labelsubValue = new Array();
			
			for(i=0; i< vallength; i++){
				labelsubValue[i] = labelValue[i].split(";");			
			}		
			
			$("input[name=windowLabelSeq]").val(seq);		
			$("input[name=windowLabelName]").val(labelName);		
			$("input[name=windowLabelExp]").val(labelExp);		
			$("input[name=windowLabelType]").val(labelType);		
			$("input[name=windowLabelvalue]").val(labelValue);
			$("input[name=windowLabelsubvalue]").val(labelsubValue);
			$("input[name=windowJoinType]").val(join_type);
			
			/* 이미지 */
			switch (labelType)
			{
				case "text"			:
					$("#text").attr("src", "../skin/default/images/common/btn_campaign_label_text_on.gif");
				break;
				case "radio"		:
					$("#radio").attr("src", "../skin/default/images/common/btn_campaign_label_multiple_on.gif");	
				break;
				case "textarea"		:
					$("#textarea").attr("src", "../skin/default/images/common/btn_campaign_label_textbox_on.gif");
				break;
				case "checkbox"		:
					$("#checkbox").attr("src", "../skin/default/images/common/btn_campaign_label_checkbox_on.gif");
				break;
				case "select"		:
					$("#select").attr("src", "../skin/default/images/common/btn_campaign_label_dropdown_on.gif");				
				break;			
				
			}
			
			html = labelAddItem(labelType, labelValue, labelsubValue);
				
			$("#labelTd").html(html);
			
		});
	}

	$("#closeBtn").click(function(){
		$("#joinDiv").hide();
	});

	$("#labelComment").click(function(){
		if ($("input[name=windowLabelComment]").val() == "N")
		{
			$("#labelCommentTr").show();
			$("input[name=windowLabelComment]").val("Y");
			$(this).attr("src", "../images/common/btn_campaign_label_comment_on.gif");
		}
		else {
			$("#labelCommentTr").hide();
			$("input[name=windowLabelComment]").val("N");
			$(this).attr("src", "../images/common/btn_campaign_label_comment.gif");
		}
	});

	$(".labelBtn").click(function(){
		var labelType = $(this).attr("id");
		var html = "";
		var msg = "";
		var labelImgSrc;

		$(".labelBtn").each(function(){
			labelImgSrc = $(this).attr("src").replace(/\_on/, "");
			$(this).attr("src", labelImgSrc);
		});

		$(".labelAdd").remove();
		html = labelAddItem(labelType);
		$("#labelTd").html(html);
		
		
		var imgSrc = $(this).attr("src").split(".gif");		
		imgSrc = imgSrc[0] + "\_on.gif";
		$(this).attr("src", imgSrc);
		var tt = $("input[name=windowLabelType]").val(labelType);		
	});

	$('#formListSelect').on("change", function(){
		var labelType = $(this).val();
		var html = "";
		$(".labelAdd").remove();
		html = labelAddItem(labelType);
	
		$("#labelTd").html(html);
		$(".sample").hide();
		var tt = $("input[name=windowLabelType]").val(labelType);
	});
	

	$("#sampleViewBtn").on("click", function(){

		var labelType = $('#formListSelect').val()+"Sample";
		
		switch(labelType)
		{
			case "textSample":
				openDialog("텍스트박스 샘플", labelType, {"width":"500","height":"400","show" : "fade","hide" : "fade"});
			break;

			case "radioSample":
				openDialog("여러개 중 택1 샘플", labelType, {"width":"400","height":"350","show" : "fade","hide" : "fade"});
			break;

			case "textareaSample":
				openDialog("에디트 박스 샘플", labelType, {"width":"400","height":"400","show" : "fade","hide" : "fade"});
			break;

			case "checkboxSample":
				openDialog("체크박스 샘플", labelType, {"width":"400","height":"400","show" : "fade","hide" : "fade"});
			break;

			case "selectSample":
				openDialog("셀렉트박스 샘플", labelType, {"width":"400","height":"300","show" : "fade","hide" : "fade"});
			break;
		}		
		
		/*
		if($("#"+labelType).css("display")== "none")
		{
			$(".sample").hide();
			$("#"+labelType).show();
			$("#"+labelType).css("top", "20px");
			$("#"+labelType).css("left", "380px");
		}else{
			$(".sample").hide();
		}*/
	});	

	$('#joinDiv').on("click", ".textAreaHeight",function(){
		
		var val = $(".textAreaHeight:checked").val();

		switch(val)
		{
			case "large" :
				$("#labelTextArea").css("height", "100px");
			break;

			case "medium" :
				$("#labelTextArea").css("height", "50px");
			break;

			case "small" :
				$("#labelTextArea").css("height", "35px");
			break;
		}
	});

	$("#labelWriteBtn").click(function(){
		
		var html = "";
		var checkTxt = "";
		var hiddenHtml = "";
		var labelValue = "";
		var labelCheck = true;
		var labelRight = "";
		var labelComment = $("input[name=windowLabelComment]").val();
		var windowLabelSeq = $("input[name=windowLabelSeq]").val();
		var windowLabelName = $("input[name=windowLabelName]").val();
		var windowLabelExp = $("input[name=windowLabelExp]").val();
		var windowLabelType = $("input[name=windowLabelType]").val();
		var windowJoinType = $("input[name=windowJoinType]").val();
		
		
		
		if (!windowLabelName){
			alert("항목명을 입력하세요.");
			$("input[name=windowLabelName]").focus();
			return false;
		}
		if (!windowLabelType){
			alert("항목을 선택하세요.");
			return false;
		}

		checkTxt = ($("input[name=windowLabelCheck]").attr("checked") == "checked") ? "필수" : "";
		var checkVal = ($("input[name=windowLabelCheck]").attr("checked") == "checked") ? "Y" : "N";
		
		switch(windowLabelType)
		{
			case "text" :
				labelValue = $("input[name='windowLabelValue[]']").size();
			break;

			case "radio" :
				$("input[name='windowLabelValue[]']").each(function(i){
					if(!$("input[name='windowLabelValue[]']").eq(i).val()){
						labelCheck = false;
						return false;
					}
					else {
						labelValue += $("input[name='windowLabelValue[]']").eq(i).val()+"|";
					}
				});
			break;

			case "textarea" :
				labelValue = $("input[name=windowLabelValue]:checked").val();
			break;

			case "checkbox" :
				$("input[name='windowLabelValue[]']").each(function(i){
					
					if(!$("input[name='windowLabelValue[]']").eq(i).val()){
						labelCheck = false;
						return false;
					}
					else {
						labelValue += $("input[name='windowLabelValue[]']").eq(i).val()+"|";
					}
				});
			break;

			case "select" :
				/*
				$("input[name='windowLabelValue[]']").each(function(i){
					if(!$("input[name='windowLabelValue[]']").eq(i).val()){
						labelCheck = false;
						return false;
					}
					else {
						labelValue += $("input[name='windowLabelValue[]']").eq(i).val()+"|";
					}
				});
				*/								

				$("#joinDiv input.windowLabelValue").each(function(i){
					
					if(!$("#joinDiv input.windowLabelValue").eq(i).val()){
						labelCheck = false;
						return false;
					}
					else {						
						var parent_label_item_seq = $("#joinDiv input.windowLabelValue").eq(i).attr('label_item_seq');
						
						var subLabelValues = new Array();
						$("#joinDiv input[name='windowSubLabelValue["+parent_label_item_seq+"][]']").each(function(){
							
							if($(this).val().length){
								subLabelValues.push($(this).val());
							}
						});
						
						labelValue += $("#joinDiv input.windowLabelValue").eq(i).val()+';'+subLabelValues.join(';')+"|";
						
					}
				});
			break;

		}

		if (labelCheck == false) {
			alert("항목값을 입력하세요.");
			return false;
		}
		
		var labelTypeText = getLabelTypeText(windowLabelType);
		if (!windowLabelSeq){
		user_layer_seq = Number(layer_seq) + 1 ;		
		order_layer_seq = Number(user_layer_seq) + 1;
		layer_seq = order_layer_seq; 
		
		//개인회원 형식
		hiddenHtml = '<input type="hidden" name="labelItem[user]['+ user_layer_seq +'][name]" value="'+ windowLabelName +'">';
		hiddenHtml += '<input type="hidden" name="labelItem[user]['+ user_layer_seq +'][type]" value="'+ windowLabelType +'">';
		hiddenHtml += '<input type="hidden" name="labelItem[user]['+ user_layer_seq +'][exp]" value="'+ windowLabelExp +'">';
		hiddenHtml += '<input type="hidden" name="labelItem[user]['+ user_layer_seq +'][joinform_seq]" value="'+ user_layer_seq +'">';
		hiddenHtml += '<input type="hidden" name="labelItem[user]['+ user_layer_seq +'][value]" value="'+ labelValue +'">';
		
		html = '<tr class="layer'+user_layer_seq+'">';		
		html += '<th>'+ windowLabelName +'</th>';
		html += '<td><label class="resp_checkbox"><input type="checkbox" name="labelItem[user]['+ user_layer_seq  +'][use]" class="user_chUse" user_ch="'+user_layer_seq+'" value="Y" /></label></td>';
		html += '<td><label class="resp_checkbox"><input type="checkbox" name="labelItem[user]['+ user_layer_seq  +'][required]" class="user_chRequired" value="Y" /></label></td>';	
		html += '<td><img src="../skin/default/images/common/icon_move.png" style="cursor:pointer"></td>'
		html += '<td class="left">['+labelTypeText+'] '+ windowLabelExp+'</td>';		
		html += '<td><button type="button" class="listJoinBtn resp_btn v2" id="listJoinBtn" value="'+ user_layer_seq  +'" join_type="user" >수정</button></td>'		
		html += '<td>'+hiddenHtml+'<button type="button" class="btn_minus" onclick="deleteRow(this)"></button></td>';
		html += '</tr>';

		$(".labelList_user").append(html);
		
		//사업자 형식
		hiddenHtml = '<input type="hidden" name="labelItem[order]['+ order_layer_seq +'][name]" value="'+ windowLabelName +'">';
		hiddenHtml += '<input type="hidden" name="labelItem[order]['+ order_layer_seq +'][type]" value="'+ windowLabelType +'">';
		hiddenHtml += '<input type="hidden" name="labelItem[order]['+ order_layer_seq +'][exp]" value="'+ windowLabelExp +'">';
		hiddenHtml += '<input type="hidden" name="labelItem[order]['+ order_layer_seq +'][joinform_seq]" value="'+ order_layer_seq +'">';
		hiddenHtml += '<input type="hidden" name="labelItem[order]['+ order_layer_seq +'][value]" value="'+ labelValue +'">';
		
		html = '<tr class="layer'+order_layer_seq+'">';		
		html += '<th>'+ windowLabelName +'</th>';
		html += '<td><label class="resp_checkbox"><input type="checkbox" name="labelItem[order]['+ order_layer_seq +'][use]" class="order_chUse" order_ch="'+order_layer_seq+'" value="Y" /></label></td>';
		html += '<td><label class="resp_checkbox"><input type="checkbox" name="labelItem[order]['+ order_layer_seq +'][required]" class="order_chRequired" value="Y" /></label></td>';	
		html += '<td><img src="../skin/default/images/common/icon_move.png" style="cursor:pointer"></td>'
		html += '<td class="left">['+labelTypeText+'] '+ windowLabelExp+'</td>';	
		html += '<td><button type="button" class="listJoinBtn resp_btn v2" id="listJoinBtn" value="'+ order_layer_seq  +'" join_type="order" >수정</button></td>'
		html += '<td>'+hiddenHtml+'<button type="button" class="btn_minus" onclick="deleteRow(this)"></button></td>';
		html += '</tr>';
		
		$(".labelList_order").append(html);
			
		}else if(windowLabelSeq){
			$(".layer"+ windowLabelSeq).remove();
			if(windowJoinType =='user'){					
				hiddenHtml = '<input type="hidden" name="labelItem[user]['+ windowLabelSeq +'][name]" value="'+ windowLabelName +'">';
				hiddenHtml += '<input type="hidden" name="labelItem[user]['+ windowLabelSeq +'][type]" value="'+ windowLabelType +'">';
				hiddenHtml += '<input type="hidden" name="labelItem[user]['+ windowLabelSeq +'][exp]" value="'+ windowLabelExp +'">';
				hiddenHtml += '<input type="hidden" name="labelItem[user]['+ windowLabelSeq +'][joinform_seq]" value="'+ windowLabelSeq +'">';
				hiddenHtml += '<input type="hidden" name="labelItem[user]['+ windowLabelSeq +'][value]" value="'+ labelValue +'">';
				
				html = '<tr class="layer'+windowLabelSeq+'">';		
				html += '<th>'+ windowLabelName +'</th>';
				html += '<td><input type="checkbox" name="labelItem[user]['+ windowLabelSeq  +'][use]" class="user_chUse" user_ch="'+windowLabelSeq+'" value="Y" /></td>';
				html += '<td><input type="checkbox" name="labelItem[user]['+ windowLabelSeq  +'][required]" class="user_chRequired" value="Y" /></td>';	
				html += '<td><img src="../skin/default/images/common/icon_move.png" style="cursor:pointer"></td>'
				html += '<td class="left">['+labelTypeText+'] '+ windowLabelExp+'</td>';	
				html += '<td><button type="button" class="listJoinBtn btn_resp b_gray2" id="listJoinBtn" value="'+ windowLabelSeq  +'" join_type="user" >수정</button></td>'
				html += '<td>'+hiddenHtml+'<button type="button" class="btn_minus" onclick="deleteRow(this)"></button></td>';
				html += '</tr>';
	
				$(".labelList_user").append(html);
				
			}else if(windowJoinType =='order'){
				
				hiddenHtml = '<input type="hidden" name="labelItem[order]['+ windowLabelSeq +'][name]" value="'+ windowLabelName +'">';
				hiddenHtml += '<input type="hidden" name="labelItem[order]['+ windowLabelSeq +'][type]" value="'+ windowLabelType +'">';
				hiddenHtml += '<input type="hidden" name="labelItem[order]['+ windowLabelSeq +'][exp]" value="'+ windowLabelExp +'">';
				hiddenHtml += '<input type="hidden" name="labelItem[order]['+ windowLabelSeq +'][joinform_seq]" value="'+ windowLabelSeq +'">';
				hiddenHtml += '<input type="hidden" name="labelItem[order]['+ windowLabelSeq +'][value]" value="'+ labelValue +'">';
				
				html = '<tr class="layer'+windowLabelSeq+'">';		
				html += '<th>'+ windowLabelName +'</th>';
				html += '<td><input type="checkbox" name="labelItem[order]['+ windowLabelSeq +'][use]" class="order_chUse" order_ch="'+windowLabelSeq+'" value="Y" /></td>';
				html += '<td><input type="checkbox" name="labelItem[order]['+ windowLabelSeq +'][required]" class="order_chRequired" value="Y" /></td>';		
				html += '<td><img src="../skin/default/images/common/icon_move.png" style="cursor:pointer"></td>'
				html += '<td class="left">['+labelTypeText+'] '+ windowLabelExp+'</td>';
				html += '<td><button type="button" class="listJoinBtn btn_resp b_gray2" id="listJoinBtn" value="'+ windowLabelSeq  +'" join_type="order" >수정</button></td>'
				//html += '<td><span class="listJoinBtn" value="'+ windowLabelSeq +'" join_type="order" style="cursor:pointer;">'+ windowLabelExp+' ('+labelTypeText+')</span></td>';
				
				html += '<td>'+hiddenHtml+'<button type="button" class="btn_minus" onclick="deleteRow(this)"></button></td>';
				html += '</tr>';
				
				$(".labelList_order").append(html);				
			}		
		}
		
		closeDialog("joinDiv");		
		//$("#joinDiv").hide()
		resetLabel();

	});

	$(".sampleBtn").click(function(){
		var position = $(window).scrollTop();
		var id = $(this).attr("id").replace(/Btn/, "");

		$(".sample").hide();
		$("#"+id).show();
	});

	$(".sampleCloseBtn").click(function(){
		$(".sample").hide();	
	});
});

function getLabelTypeText(labelType)
{
	var msg = "";
	switch (labelType)
	{
		case "text" :			msg = "텍스트박스";			break;
		case "radio" :			msg = "여러개 중 택1";		break;
		case "textarea" :		msg = "에디트박스";			break;
		case "checkbox" :		msg = "체크박스";			break;
		case "select" :			msg = "셀렉트박스";			break;

	}

	return msg;
}

function resetLabel()
{
	$("input[name=windowLabelSeq]").val("");
	$("input[name=windowLabelName]").val("");
	$("input[name=windowLabelExp]").val("");
	$("input[name=windowLabelType]").val("");
	$("#labelTd").html("우측에서 항목값을 선택하세요 ");
	$("input[name=windowLabelComment]").val("N");
	$("input[name=windowLabelCheck]").attr("checked", false);
	$("#labelCommentTr").hide();
	$(".labelAdd").remove();
	$("#labelComment").attr("src", "../images/btn_campaign_label_comment.gif");
	$(".sample").hide();

	$(".labelBtn").each(function(){
		labelImgSrc = $(this).attr("src").replace(/\_on/, "");
		$(this).attr("src", labelImgSrc);
	});
}

function joinDivShow()
{
	openDialog("가입항목 추가","joinDiv",{"width":"450","height":"450"});
	/*var position = $(window).scrollTop(); // 현재 스크롤바의 위치값을 반환합니다.
	$("#joinDiv").css("top", position+150);
	$("#joinDiv").show();*/

	if($('#formListSelect'))
	{
		$("#formListImgType").hide();
		$('#formListSelect').val("text").trigger("change");
	}
}

function rightChange(obj)
{
	if ($(obj).text() == "T") {
		$(obj).text("F");
	}
	else {
		$(obj).text("T");
	}
}

function labelAdd(type, right)
{
	var html = '<tr class="labelAdd"><td></td>';
	var category = $("input[name=category]").val();

	switch(type)
	{
		case "text" :
			html += '<td>';
			if (right) {
				html += '<tr class="labelAdd"><th align="left" style="width:65px;"></th>';
				html += '<td>';
				html += '<input type="text" name="windowLabelRight[]" value="" size="30"> <button type="button"  class="pointer btn_minus" onclick="deleteRow(this)"></button>';
				html += '</td>';
				html += '</tr>';
			}
			else {
				html += '<input type="text" name="windowLabelValue[]" size="30"> <button type="button" class="pointer btn_minus" onclick="deleteRow(this)"></button>';
			}
			html += '</td>';
			html += '</tr>';
		break;

		case "radio" :
			html += '<td>';
			if (right) {
				html += '<tr class="labelAdd"><th align="left" style="width:65px;"></th>';
				html += '<td>';
				html += '<input type="text" name="windowLabelRight[]" value=""  size="30"> <button type="button" class="pointer btn_minus" onclick="deleteRow(this)"></button>';
				html += '</td>';
				html += '</tr>';
			}
			else {
				html += '<input type="radio" name="labelKey[]" class="null " disabled> <input type="text" name="windowLabelValue[]" size="30"> <button type="button" class="pointer btn_minus" onclick="deleteRow(this)"></button>';
			}
			html += '</td>';
			html += '</tr>';
		break;

		case "checkbox" :
			html += '<td>';
			if (right) {
				html += '<tr class="labelAdd"><th align="left" style="width:65px;"></th>';
				html += '<td>';
				html += '<input type="text" name="windowLabelRight[]" value=""  size="30"> <input type="button" class="pointer btn_plus" onclick="deleteRow(this)"></button>';
				html += '</td>';
				html += '</tr>';
			}
			else {
				html += '<input type="checkbox" name="labelKey[]" class="null resp_checkbox"> <input type="text" name="windowLabelValue[]" size="30"> <button type="button" class="pointer btn_minus" onclick="deleteRow(this)"></button>';
			}
			html += '</td>';
			html += '</tr>';
		break;

		case "select" :
			html += '<td>';
			if (right) {
				if ($("#selectRight").size() > 0)
				{
					alert("정답은 하나 이상 등록할 수 없습니다.");
					return false;
				}
				html += '<tr class="labelAdd"><th align="left" style="width:65px;"></th>';
				html += '<td>';
				html += '<input type="text" name="windowLabelRight['+label_item_seq+']" id="selectRight" size="30"> <button type="button" class="pointer btn_minus" onclick="deleteRow(this)"></button><button type="button" class="pointer btn_plus" onclick="labelSubAdd('+label_item_seq+')"></button>';
				html += '</td>';
				html += '</tr>';
			}
			else {
				html += '<input type="text" name="windowLabelValue['+label_item_seq+']" class="windowLabelValue line" label_item_seq="'+label_item_seq+'" size="30"> <button type="button" class="pointer btn_minus" onclick="deleteRow(this)"></button> <button type="button" class="pointer btn_plus gray" onclick="labelSubAdd('+label_item_seq+')"></button>';
			}
			html += '</td>';
			html += '</tr>';
			
			label_item_seq++;
		break;

	
	}

	if (right)
	{
		$("#labelRightTable").append(html);
	}
	else {
		$("#labelTable").append(html);
	}
}

function labelSubAdd(parent_label_item_seq){
	
	var html = '<tr class="labelAdd"><td></td><td>';
	html += '→ <input type="text" name="windowSubLabelValue['+parent_label_item_seq+'][]" size="27" margin-left:3px;" class="line"> <button type="button" class="pointer btn_minus gray" onclick="deleteRow(this)"></button>';
	html += '</td></tr>';
	
	if($('input[name="windowSubLabelValue['+parent_label_item_seq+'][]"]').length){
		$('input[name="windowSubLabelValue['+parent_label_item_seq+'][]"]').last().closest('tr').after(html);
	}else{
		$("input[name='windowLabelValue["+parent_label_item_seq+"]']").closest('tr').after(html);
	}
}

function labelAddItem(labelType, labelValue, labelsubValue)
{
	var html = "";
	var labelTableHtml = "";
	var labelRightHtml = "";
	var category = $("input[name=category]").val();


	
	switch(labelType)
	{
		case "text" :

			html = '<input type="text" name="windowLabelValue[]" size="30"> <button type="button" class="pointer btn_plus" onclick="labelAdd(\'text\')" ></button>';
			if (labelValue && labelValue > 1)
			{
				for (i=1; i<labelValue; i++)
				{
					labelTableHtml += '<tr class="labelAdd"><td></td>';
					labelTableHtml += '<td>';
					labelTableHtml += '<input type="text" name="windowLabelValue[]" size="30" > <button type="button" class="pointer btn_minus" onclick="deleteRow(this)"></button>';
					labelTableHtml += '</td>';
					labelTableHtml += '</tr>';
				}
			}

			$("#labelTable").append(labelTableHtml);

					break;

		case "radio" :
			if (labelValue)
			{
				html = '<input type="radio" name="labelKey[]" class="null" disabled> <input type="text" name="windowLabelValue[]" value="'+ labelValue[0] +'" size="30">..<br/><input type="radio" name="labelKey[]" class="null" disabled> <input type="text" name="windowLabelValue[]" value="'+ labelValue[1] +'" size="30" style="height:18px;" class="line"> <button type="button" class="pointer btn_plus" onclick="labelAdd(\'radio\')"></button>';
			

				var count = labelValue.length-1;
				if (count > 2)
				{
					for (i=2; i<count; i++)
					{
						labelTableHtml += '<tr class="labelAdd"><td></td>';
						labelTableHtml += '<td>';
						labelTableHtml += '<input type="radio" name="labelKey[]" class="null" disabled> <input type="text" name="windowLabelValue[]" value="'+ labelValue[i] +'" size="30"> <button type="button" class="pointer btn_minus" onclick="deleteRow(this)"></button>';
						labelTableHtml += '</td>';
						labelTableHtml += '</tr>';
					}
				}
			}
			else {
				html = '<input type="radio" name="labelKey[]" class="null" disabled> <input type="text" name="windowLabelValue[]" value="" size="30" ><br/><input type="radio" name="labelKey[]" class="null" disabled> <input type="text" name="windowLabelValue[]" value="" size="30" class="mt3"> <button type="button" class="pointer btn_plus" onclick="labelAdd(\'radio\')"></button>';
			}
			
			$("#labelTable").append(labelTableHtml);


		break;

		case "textarea" :
			
			var ckValueL = "";			
			var ckValueM = "";
			var ckValueS = "";
			
			if(labelValue == "large"){				
				 ckValueL = "checked";
			}
			if(labelValue == "medium"){				
				 ckValueM = "checked";
			}
			if(labelValue == "small"){				
				 ckValueS = "checked";
			}
			if(!labelValue){				
				 ckValueM = "checked";
			}
			
			html = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
			html += '<tr>';
			html += '<td>';
			html += '<textarea id="labelTextArea" name="labelTextArea" style="width:250px; height:50px; padding:0;" class="line"></textarea></td></tr>';
			html += '<tr>';
			html += '<td>박스크기 : <div class="resp_radio mt5"><label><input type="radio" name="windowLabelValue" value="large" class="textAreaHeight null" '+ ckValueL +'> large</label>';
			html += '<label><input type="radio" name="windowLabelValue" value="medium" class="textAreaHeight null" '+ ckValueM +'> medium </label>';
			html += '<label><input type="radio" name="windowLabelValue" value="small" class="textAreaHeight null" '+ ckValueS +'> small </label></div></td>';
			html += '</tr>';
			html += '</table>';
		break;

		case "checkbox" :
			if (labelValue)
			{
				html = '<label class="resp_checkbox"><input type="checkbox" name="labelContent[]" class="null" disabled></label> <input type="text" name="windowLabelValue[]" value="'+ labelValue[0] +'" size="30"> <div class="mt3"><label class="resp_checkbox"><input type="checkbox" name="labelContent[]" class="null" disabled></label> <input type="text" name="windowLabelValue[]" value="'+ labelValue[1] +'" size="30"> <button type="button" class="pointer btn_plus" onclick="labelAdd(\'checkbox\')"></button></div>';
				
				var count = labelValue.length-1;
				if (count > 2)
				{
					for (i=2; i<count; i++)
					{
						labelTableHtml += '<tr class="labelAdd"><td></td>';
						labelTableHtml += '<td>';
						labelTableHtml += '<label class="resp_checkbox"><input type="checkbox" name="labelKey[]" class="null" disabled></label> <input type="text" name="windowLabelValue[]" value="'+ labelValue[i] +'" size="30"> <button type="button" class="pointer btn_minus" onclick="deleteRow(this)"></button>';
						labelTableHtml += '</td>';
						labelTableHtml += '</tr>';
					}
				}
			}
			else {
				html = '<input type="checkbox" name="labelContent[]" class="null" disabled> <input type="text" name="windowLabelValue[]" value="" size="30"> <button type="button" class="pointer btn_plus" onclick="labelAdd(\'checkbox\')"></button>';

			}
			$("#labelTable").append(labelTableHtml);
		break;

		case "select" :

			if (labelValue)
			{							
				var count = labelValue.length-1;
				var subcount = 0;
				var j=0;
				
				html = '<input type="text" name="windowLabelvalue['+label_item_seq+']" label_item_seq="'+label_item_seq+'" value="'+ labelsubValue[0][0] +'" size="30" class="windowLabelValue"> <button type="button" class="pointer btn_plus" onclick="labelAdd(\'select\')"></button> <button type="button" class="pointer btn_plus" onclick="labelSubAdd('+label_item_seq+')"></button>';
				subcount = labelsubValue[0].length;
				
				if (subcount > 1)
				{
					for (j=1; j<subcount; j++)
					{	
						labelTableHtml += '<tr class="labelAdd"><td></td><td>';
						labelTableHtml += '→ <input type="text" name="windowSubLabelValue['+label_item_seq+'][]" value="'+ labelsubValue[0][j] +'" size="27" style="margin-left:3px;"> <button type="button" class="pointer btn_minus" onclick="deleteRow(this)"></button>';
						labelTableHtml += '</td></tr>';						
					}
				}			
				
				if (count > 1)
				{
					for (i=1; i<count; i++)
					{
						label_item_seq++;
						
						labelTableHtml += '<tr class="labelAdd"><td></td>';
						labelTableHtml += '<td>';
						labelTableHtml += '<input type="text" name="windowLabelvalue['+label_item_seq+']" label_item_seq="'+label_item_seq+'" value="'+ labelsubValue[i][0] +'" size="30" class="windowLabelValue"> <button type="button" class="pointer btn_minus" onclick="deleteRow(this)"></button> <button type="button" class="pointer btn_plus" onclick="labelSubAdd('+label_item_seq+')"></button>';
						labelTableHtml += '</td>';
						labelTableHtml += '</tr>';
						subcount = labelsubValue[i].length;
						
						if (subcount > 1)
						{
							for (j=1; j<subcount; j++)
							{	
								labelTableHtml += '<tr class="labelAdd"><td></td><td>';
								labelTableHtml += '→ <input type="text" name="windowSubLabelValue['+label_item_seq+'][]" value="'+ labelsubValue[i][j] +'" size="27" style="margin-left:3px"> <button type="button" class="pointer btn_minus" onclick="deleteRow(this)"></button>';
								labelTableHtml += '</td></tr>';
							}
						}						
						
					}
				}
				
			}
			else {
				html = '<input type="text" name="windowLabelValue['+label_item_seq+']" class="windowLabelValue line" label_item_seq="'+label_item_seq+'"  size="30" > <button type="button"  class="pointer btn_plus" onclick="labelAdd(\'select\')"></button> <button type="button" class="pointer btn_plus gray" onclick="labelSubAdd('+label_item_seq+')"></button>';
				label_item_seq++;
			}
			$("#labelTable").append(labelTableHtml);
		break;

		
	}
	
	return html;
}

function deleteRow(obj){

	if ($("input[name=campaignMemberCount]").val() > 0)
	{
		alert("참여자가 있을 경우 참여형식을 수정할 수 없습니다.");
		return false;
	}

	$(obj).parent().parent().remove();
} 



function deleteAddRow(seq){

	if ($("input[name=campaignMemberCount]").val() > 0)
	{
		alert("참여자가 있을 경우 참여형식을 수정할 수 없습니다.");
		return false;
	}

	$(".layer"+seq ).remove();
} 


function alertFocus(msg, target)
{
	if (msg) alert(msg);
	if (target) target.focus();
}