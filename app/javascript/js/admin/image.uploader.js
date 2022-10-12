// shopname = multi / single / mshop / editor
// swfuploader
var swfuploader = {
		isSwf				: true,
		shopname			: 'multi',
		'script'			: krdomain+'/admin/goods_process/upload_file_multi',
	    'uploader'			: '/app/javascript/plugin/jquploadify/uploadify.swf',
	    'buttonImg'			: '/app/javascript/plugin/jquploadify/uploadify-search.gif',
	    'cancelImg'			: '/app/javascript/plugin/jquploadify/uploadify-cancel.png',
	    'fileTypeExts'		: '*.jpg;*.gif;*.png;*.jpeg',
	    'fileTypeDesc'		: 'Image Files (.JPG, .GIF, .PNG)',
	    'fileSizeLimit'		: '20MB',
	    'removeCompleted'	: true,
		'width'				: 64,
		'height'			: 20,
		'folder'			: '/data/tmp',
	    'auto'				: true,
	    'multi'				: true,
	    'scriptData'		: '',
	    'onComplete'		: function (event, ID, fileObj, response, data) {

	    	var data = eval(response)[0];
			if( swfuploader.shopname == 'multi' ) {
				uploadResult.multiComplete(data);
			}
			else if( swfuploader.shopname == 'single' ) {
				uploadResult.singleComplete(data);
			}
			else if( swfuploader.shopname == 'mshop' ) {
				uploadResult.mshopComplete(data);
			}
			else if( swfuploader.shopname == 'editor' ) {

				uploadResult.editorComplete(data);
			}
			else if( swfuploader.shopname == 'mobileEditor' ) {

				uploadResult.mobileEditorComplete(data);
			}

		},
		'onAllComplete'		: function() {
			// window.self.close();
			if( swfuploader.shopname == 'editor') {
				if(!korea_domain)closeWindow();
			}
		},
		'onError'			: function (event,ID,fileObj,errorObj) {
			alert(errorObj.type + ' Error: ' + errorObj.info);
			window.self.close();
		}
};

// html5uploader
var html5uploader = {
	isSwf 				: false,
	shopname			: 'multi',
	url					: krdomain+'/admin/goods_process/upload_file_multi',
	uploadTotalByte : 0,
	uploadSucessByte: 0,
    dataType			: 'json',
    formData			: '',
    acceptFileTypes		: /^image\/(gif|jpe?g|png)$/i,
    acceptMessage		: '이미지 파일(gif, png, jpeg, jpg)만 선택해 주세요.',
    add					: function(e, data) {
        var uploadErrors = [];
        //var acceptFileTypes = /^image\/(gif|jpe?g|png)$/i;
        if(
			data.originalFiles[0]['type'].length
			&& !html5uploader.acceptFileTypes.test(data.originalFiles[0]['type'])
        	&& html5uploader.shopname != "editor"
		) {
            uploadErrors.push(html5uploader.acceptMessage);
        }
        else if(
			(data.originalFiles[0]['size'] 
			&& data.originalFiles[0]['size'] > 20000000) 
			? true : false 
		) {
            uploadErrors.push('20MB 이하의 파일만 선택 하여 주세요.');
        }

        if(uploadErrors.length > 0) {
            alert(uploadErrors.join("\n"));
        } else {
            data.submit();
        }
    },
	// 각 파일 업로드가 완료될때 마다 호출되는 callback
    done : function (e, datas) {
        $.each(datas.result, function (index, data) {
        	if( data.status != 1 ){
        		$('#progress').hide();
        	}

        	if( html5uploader.shopname == 'multi' ) {
				uploadResult.multiComplete(data);
			} else if( html5uploader.shopname == 'single' ) {
				uploadResult.singleComplete(data);
			} else if( html5uploader.shopname == 'mshop' ) {
				uploadResult.mshopComplete(data);
			} else if( html5uploader.shopname == 'editor' ) {
				uploadResult.editorComplete(data);
			} else if( html5uploader.shopname == 'mobileEditor' ) {
				uploadResult.mobileEditorComplete(data);
			}
        });
		// 퍼센트 계산을 위해, 업로드 완료시 업로드된 데이터를 더해줌
		html5uploader.uploadSucessByte += datas.loaded;	
		html5uploader.drawProgress();
		html5uploader.closeProgress();
    },
	progressPercent : function () {
		return parseInt(html5uploader.uploadSucessByte / html5uploader.uploadTotalByte * 100, 10);
	},
	closeProgress: function () {
		if (html5uploader.progressPercent() >= 100) {
			window.setTimeout(function () {
				$('#progress').hide();
				
				// 에디터 편집기에서 띄운 파일업로드 팝업창인 경우
				if (html5uploader.shopname === 'editor' && !korea_domain) {
					closeWindow();
				}
			}, 1000);
		}
	},
	drawProgress: function () {
		var style = {
			'width': html5uploader.progressPercent() + '%',
			'background-color': 'lightblue',
			'height': '5px' 
		};
		$('#progress .progress-bar').css(style);
	},
    fail : function (e, data) {
    	alert("이미지 가로 혹은 세로 사이즈를 5000 이하로 줄여 주신 후에 업로드 하여 주세요.");
    	$('#progress').hide();
    },
	// 각 파일 업로드가 서버에 전송 될때마다 호출되는 callback
    progressall : function (e, data) {
		$('#progress').show();

		// 업로드 전체 데이터 크기 등록
		if (html5uploader.uploadTotalByte === 0) {
			html5uploader.uploadTotalByte = data.total;
		}
    }
};


// uploader selector
var fileuploader = new function() {
	this.uploader = html5uploader;

	this.select = function() {
		var version = Browser.detectIE();
		
		if( version && version < 11 ) {
			this.uploader = swfuploader;
		}
		if( kordomainck ) {
			this.uploader = html5uploader;
		} 
		//this.uploader = swfuploader;
		//this.uploader = html5uploader;
		return this.uploader;
	};

};

// upload complete
var uploadResult = {
		multiComplete : function(data) {
			if( data.status ) {

				var newImg	= data.newFile + 'view' + data.ext;
				var imgTag	= newImg + '<img src="'+newImg+'" height="50" class="pd5" style="vertical-align: middle;" /> ';
				var viewer	= '<div><input type="hidden" name="uploadImg[]" value="'+newImg+'" />'+ imgTag+'</div>';
				$("#imgtb").show();
				$("#img_viewer .nothing").hide();
				$("#img_viewer").append(viewer);
			}else {
				alert(data.msg);
			}
		},
		singleComplete : function(data) {
			if( data.status ) {
				var division = 'view';
				if(data.division != undefined ){
					division = data.division;
					if(data.division == 'all') division = 'view';
				}

				var newImg	= data.newFile + division + data.ext;
				var imgTag	= '<img src="'+newImg+'" height="50" class="pd5" /> ';

				$("input[name='uploadImg']").val(newImg);
				$("#imgView").html(imgTag);
			}
			else {
				alert(data.msg);
			}

		},
		mshopComplete : function(data) {
			if(data.status){//업로드성공
				result_value	= data.newFile + data.ext;
				$("#result_filename").val(result_value);
				$("#result_fileext").val(data.ext);

				var viewer	= '<div>'+ result_value+'</div>';
				$("#imgtb").show();
				$("#img_viewer").append(viewer);

			}else{
				$("#uploader").uploadifyCancel();
				$("#uploadernQueue").empty();
				$("#uploader").uploadifyClearQueue();
				alert(data.msg);
			}
		},
		editorComplete : function(result) {

			if(result.status!=1){
				alert(result.msg,400,150);
				$("#uploader").find(".percentage").html("<font color='red'> - "+result.desc+"</font>");
				
				return false;
			}else{

				result.fileInfo.file_size = parseInt(result.fileInfo.file_size*1000);
				if( iskorea_domain ) {
					if(result.fileInfo.is_image == true ){
						_mockdata = 'is_image=1&imageurl='+ result.filePath + '&filename=' + result.fileInfo.client_name+ '&filesize='+ result.fileInfo.file_size+ '&imagealign=C&originalurl='+result.filePath + '&thumburl='+ result.filePath;
					}else{
						_mockdata = 'is_files=1&&filename=' + result.fileInfo.client_name+ '&filesize='+ result.fileInfo.file_size+ '&filemime='+result.filetype + '&attachurl='+ result.filePath;
					}
					//document.location.href= "http://" + "<?echo  ($_GET['redomain'])?>" + "/app/javascript/plugin/editor/pages/trex/file.html?"+_mockdata+"&redomain=<?echo $_GET['redomain']?>";
					document.location.href= "http://" + korea_domain + "/app/javascript/plugin/editor/pages/trex/file.html?"+_mockdata+"&redomain=" + korea_domain;
				}
				else {
					PopupUtil.getOpener().Editor.getSidebar().getAttacher().image.boxonly = false;
					PopupUtil.getOpener().Editor.getSidebar().getAttacher().file.boxonly = true;

					if(result.fileInfo.is_image == true ){
						_mockdata = {
							'imageurl': result.filePath,
							'filename': result.fileInfo.client_name,
							'filesize': result.fileInfo.file_size,
							'imagealign': 'C',
							'originalurl': result.filePath,
							'thumburl': result.filePath
						};
						PopupUtil.getOpener().Editor.focus();//focusOnBottom();
						PopupUtil.getOpener().Editor.getSidebar().getAttacher("image").execAttach(_mockdata);

						//<!--{ ? !service_limit && config_watermark.watermark_setting_status }-->
						if($("input[name='watermark_apply']").is(":checked")){
							$.ajax({
								'url' : '/common/editor_image_watermark',
								'type' : 'post',
								'async' : false,
								'data' : {'target_image':_mockdata.imageurl},
								'success' : function(res){
									if(res!='OK'){
										alert('워터마크 적용 실패');
									}
								}
							});
						}
					}
					else {
						_mockdata = {
								'filename': result.fileInfo.client_name,
								'filesize': result.fileInfo.file_size,
								'filemime':result.filetype,
								'attachurl': result.filePath
							};
							PopupUtil.getOpener().Editor.focus();//focusOnBottom();
							PopupUtil.getOpener().Editor.getSidebar().getAttacher("file").execAttach(_mockdata);
					}
				}
			}
		},
		mobileEditorComplete : function(result) {
			if(result.status!=1){
				alert(result.msg,400,150);
				$("#uploader").find(".percentage").html("<font color='red'> - "+result.desc+"</font>");

				return false;
			}else{

				var _opener = PopupUtil.getOpener();
				if(!_opener) {
					alert('잘못된 경로로 접근하셨습니다.');
					return;
				}

				if(result.is_image == true ){
					var newImg		= result.uploadFile[0].split("^^")[0];
					var incFile		= result.incFile;
					var filepath	= '';
					if(result.board){
						filepath = '/data/board/' + result.board + '/';
					}
					
					var imgTag	= '<img src="'+filepath+newImg+'" height="50" class="pd5" style="vertical-align: middle;" /> ';
					var viewer	= '<div>' + imgTag + ' <font size="+1">' + newImg+'</font></div>';
					$("#imgtb").show();
					$("#img_viewer").append(viewer);
					
					realfilename.push(result.uploadFile[0]);
					incimage.push(incFile);
			}
		}
	}

};
