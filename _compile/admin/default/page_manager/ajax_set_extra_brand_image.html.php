<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/ajax_set_extra_brand_image.html 000007380 */ 
$TPL_brand_list_1=empty($TPL_VAR["brand_list"])||!is_array($TPL_VAR["brand_list"])?0:count($TPL_VAR["brand_list"]);?>
<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/dropzone/dropzone.css?v=<?php echo date('YmdHis')?>" />
<script src="/app/javascript/plugin/dropzone/dropzone.js?v=<?php echo date('YmdHis')?>"></script>

<style type="text/css">
.img-area			{ width:100%;height:600px;overflow-y:scroll; }
.brand_image_area	{ height:145px; }
.brand-item			{ border:1px dotted gray;width:100px;height:100px;font-size:30px; }
.plus-brand-item	{ width:100%; height:100%; }
.preview_item		{ position:relative; display:flex !important; flex-direction:row; justify-content:center; }
.plus				{ position: absolute; top: 44px; pointer-events: none;}
</style>
<script type="text/javascript">

var dzObj = [];
var maxfileCnt = 1; // dropzone 영역1개당 이미지
$(document).ready(function() {
	help_tooltip();
	$(".plus-brand-item").each(function(idx, obj){
		cate_code = $(this).closest('.brand_image_area').attr('category_code');
		dzObj[idx] = new Dropzone('#drop_idx_' + idx, {
			url: '../page_manager_process/upload_brand_img',
			paramName: 'brand_image_' + cate_code, 
			previewsContainer: '#template-preview_'+idx,
			acceptedFiles: '/admin/skin/default/page_manager/.jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF',
			maxFiles: maxfileCnt, 
			autoProcessQueue: true,
			autoQueue: true, // Make sure the files aren't queued until manually added
			thumbnailWidth:99, 
			thumbnailHeight:99, 
			previewTemplate: $('div.dz-preview').html(),
			hiddenInputContainer: "#brandImageSettingForm",
			maxfilesexceeded: function(file) {
				// 초과영역 업로드 시 삭제처리
				delete_brand_img(cate_code, idx);
            },
			error : function(file,response){
				alert('파일 업로드 오류 (' + response + ')');
				delete_brand_img(cate_code, idx);
			}
		}).on('success', function(file, res) {
			var json_res = eval ("(" + res + ")");
			if(json_res.cate_code != 'err'){
				var file_obj = $('input[name="brand_image[' + json_res.cate_code + ']"]');
				if(!file_obj){
					$('form#brandImageSettingForm').append('<input type="hidden" name="brand_image[' + json_res.cate_code + ']" value="' + json_res.file_url + '" />');
				}
				$('input[name="brand_image[' + json_res.cate_code + ']').val(json_res.file_url);
			}else{
				alert('파일 업로드 오류 - 고객센터로 연락주세요.');
			}
        });
		// 이미지 추가 이벤트
		dzObj[idx].on('drop', function(file){
			// 기존 파일 위에 덮을때
			var now_code = $('div#template-preview_' + idx).closest('.brand_image_area').attr('category_code');
			img_path = $('input[name="brand_image[' + now_code + ']"]').val();
			if(img_path){
				delete_brand_img(now_code, idx);
			}
		});
		// 이미지 추가 후처리 이벤트
		dzObj[idx].on('addedfile', function(file){
			$('div#template-preview_' + idx).css('margin-top', '0').find('span.plus').html('').hide();
		});
		// 이미지 삭제 이벤트
		dzObj[idx].on('removedfile', function(file){
			$('div#template-preview_' + idx).css('margin-top', '40px').find('span.plus').html('+').show();
		});
		dzObj[idx].on('dragstart', function(e){
			e.preventDefault();
			e.stopPropagation();
		});
	});

	// 이외 영역 파일 드래그 무력화 :: 2018-12-26 lwh
	$('#divlayer').on('dragover', function(e) {
			e.preventDefault();
			e.stopPropagation();
		}
	).on('dragenter',function(e) {
			return false;
			e.preventDefault();
			e.stopPropagation();
		}
	).on('drop',function(e){
			if(e.originalEvent.dataTransfer){
				if(e.originalEvent.dataTransfer.files.length) {
					e.preventDefault();
					e.stopPropagation();
				}   
			}
		}
	);
});

// 기존 이미지 삭제
function delete_brand_img(code, idx){
	var img_path = $('input[name="brand_image[' + code + ']"]').val();
	if(img_path){
		// 삭제 영역 검증 및 이미지 삭제처리
		var real_code	= $('.brand_' + code).attr('category_code');
		var real_idx	= $('.brand_' + code).attr('idx');
		if(real_code == code && real_idx == idx)	$('input[name="brand_image[' + code + ']"]').val('delete');

		// 화면 삭제 처리
		$('div#template-preview_' + idx).html('<span class="plus">+</span>').show();
		dzObj[idx].removeAllFiles(true);
	}else{
		alert('삭제할 이미지가 없습니다.');
	}
}

// 최종 저장처리
function submit_form(){
	// ajax 저장
	$.ajax({
		type: "post",
		url: "../page_manager_process/modify_brand_image",
		dataType : 'json',
		data: $("#brandImageSettingForm").serialize(),
		success: function(res){
			if(res.cnt > 0){
				alermSuccess();
				ajax_main_body_layer();
				closeDialog('setCtrlLayer');
			}else{
				alert('수정된 이미지가 없습니다.');
			}
		}
	});
}
</script>
<div id="divlayer">
<form id="brandImageSettingForm" name="brandImageSettingForm" method="post" enctype="multipart/form-data" target="actionFrame">

<table class="info-table-style" width="100%" height="90%" cellspacing="0" cellpadding="0">
<tr>
	<th class="its-th-align center" height="20px;">브랜드 이미지 리스트 <span class="helpicon" title="파일 탐색기에서 직접 드래그하여 네모칸안에 업로드하세요"></span></th>
</tr>
<tr>
	<td class="its-td center" height="600px">
		<div class="img-area">
<?php if($TPL_brand_list_1){$TPL_I1=-1;foreach($TPL_VAR["brand_list"] as $TPL_V1){$TPL_I1++;?>
			<div class="fl mr20 brand_image_area brand_<?php echo $TPL_V1["category_code"]?>" category_code="<?php echo $TPL_V1["category_code"]?>" idx="<?php echo $TPL_I1?>" >
				<table width="100%" height="100%" cellspacing="0" cellpadding="0">
				<tr><td class="right"><span class="highlight-link hand" onclick="delete_brand_img('<?php echo $TPL_V1["category_code"]?>', '<?php echo $TPL_I1?>')">삭제</span></td></tr>
				<tr>
					<td class="center">
						<div class="brand-item">
							<div id="drop_idx_<?php echo $TPL_I1?>" class="dropzone plus-brand-item">
								<div class="preview_item" id="template-preview_<?php echo $TPL_I1?>">
<?php if($TPL_V1["brand_image"]){?>
									<img src="<?php echo $TPL_V1["brand_image"]?>?v=<?php echo date('YmdHis')?>" width="99" height="99" style="cursor:pointer;" onclick="window.open('<?php echo $TPL_V1["brand_image"]?>');" />
<?php }else{?>
									<span class="plus">+</span>
<?php }?>
								</div>
							</div>

						</div>
						<input type="hidden" name="brand_image[<?php echo $TPL_V1["category_code"]?>]" value="<?php echo $TPL_V1["brand_image"]?>" />
					</td>
				</tr>
				<tr>
					<td class="center"><?php echo $TPL_V1["title"]?></td>
				</tr>
				</table>
			</div>
<?php }}?>
		</div>
	</td>
</tr>
</table>
<div class="center pdt10">
	<span class="btn large black"><button type="button" onclick="submit_form();">저장</button></span>
</div>
</form>
</div>
<div style="display:none;">
	<div class="dz-preview dz-file-preview">
		<div class="dz-details">
			<div class="dz-filename"><span data-dz-name style="display:none;"></span></div>
			<img data-dz-thumbnail />
		</div>
	</div>
</div>