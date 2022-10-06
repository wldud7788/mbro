<?php /* Template_ 2.2.6 2021/12/31 13:45:04 /www/music_brother_firstmall_kr/admin/skin/default/statistic_visitor/visitor_setting.html 000008249 */ 
$TPL_statisticExcludeIp_1=empty($TPL_VAR["statisticExcludeIp"])||!is_array($TPL_VAR["statisticExcludeIp"])?0:count($TPL_VAR["statisticExcludeIp"]);?>
<script type="text/javascript">
	$(document).ready(function() {
		
		/* IP 입력칸 포커싱 처리*/
		$(".ip_input").each(function(){
			var that = this;
			$("input",this).each(function(idx){
				$(this).bind('change keyup',function(event){
					// 쉬프트, 탭키는 무시
					if(event.keyCode==9 || event.keyCode==16) return;
					
					$(this).val($(this).val().replace(/[^0-9.]/g,""));
					
					thisInput = this;
					
					var check_band_ok = function(thisClassValue){
						thisClassValue = parseInt(thisClassValue);
						
						if(thisClassValue<0 || thisClassValue>255){
							openDialogAlert("0~255 사이의 숫자만 입력해주세요.",400,140,function(){
								$(thisInput).val('').focus();
							});
							return false;
						}
						
						if($(thisInput).val()!='0'){
							$(thisInput).val($(thisInput).val().replace(/^0*/g,""));
						}

						return true;
					};

					if($(this).val().length>=3 || (/[.]/).test($(this).val())){
						var val = $(this).val();
						
						for(var i=0;i<val.length;i++){
							if(val.substring(i,i+1)=='.'){
								$(this).val(val.substring(0,i));
								if(!check_band_ok($(this).val())) return;
								$("input",that).eq(idx+1).focus().val(val.substring(i+1,val.length)).change();
								break;
							}
							
							if(val.substring(0,i+1).length>=3){
								$(this).val(val.substring(0,i+1));
								if(!check_band_ok($(this).val())) return;
								if(val.substring(i+1,i+2)=='.'){
									$("input",that).eq(idx+1).focus().val(val.substring(i+2,val.length)).change();
								}else{
									$("input",that).eq(idx+1).focus().val(val.substring(i+1,val.length)).change();
								}
								break;
								
							}
							
							
						}
					}
					
					check_band_ok($(this).val());
				});

				$(this).bind('keydown',function(event){

					// 백스페이스 처리
					if(event.keyCode==8 && $(this).val().length==0){
						if(idx>0){
							$("input",that).eq(idx-1).focus();
							$("input",that).eq(idx-1).val($("input",that).eq(idx-1).val().substring(0,2));
							
							return false;
						}
					}

					// 점 처리
					if(event.keyCode==190 || event.keyCode==110){
						if(idx<4 && $(this).val().length>=1){
							$("input",that).eq(idx+1).focus();
						}
						return false;
					}
					
				});
				
			});
		});
		
		/* 차단IP 추가 버튼 */
		$("#btn_add_banip").click(function(){
			var ip = '';
			var ip_end = false;

			var ipInputSelector = ".new_ip_input input";
			for(var i=0;i<$(ipInputSelector).length;i++){
				$(ipInputSelector).eq(i).val($(ipInputSelector).eq(i).val().replace(/ /,''));
				if($(ipInputSelector).eq(i).val().length){
					if(ip_end){
						openDialogAlert("아이피 중간을 비워둘 수 없습니다.",400,140,function(){
							$(ipInputSelector).eq(i-1).focus();
						});
						return;
					}
					ip += $(ipInputSelector).eq(i).val();
					if(i<3) ip += '.';
				}else{
					ip_end = true;
				}
			}
			
			add_banip(ip,'prepend');
			
		});
		
		/* 차단IP 검색 버튼*/
		$("#btn_search_banip").click(function(){
			
			var ip = '';
			$(".search_ip_input input").each(function(idx){
				if($(this).val()){
					if(idx) ip += '.';
					ip += $(this).val();
				}
			});	
		
			$("#ip_list .ip_item").each(function(){
				if($("input[name='statisticExcludeIp[]']",this).val().substring(0,ip.length)==ip){
					$(this).show();
				}else{
					$(this).hide();
				}
			});
			
			$(".search_ip_input input").attr("disabled",true);
			$(this).attr("disabled",true);
			
		});
		
		/* 차단IP 검색 초기화 버튼*/
		$("#btn_reset_banip").click(function(){
			$("#btn_search_banip").removeAttr("disabled");
			$(".search_ip_input input").removeAttr("disabled");
			$(".search_ip_input input").val('').eq(0).focus();
			$("#ip_list .ip_item").show();
		});
		
		/* 추가 IP 입력폼 엔터키 */
		$(".new_ip_input input").bind('keydown',function(event){
			if(event.keyCode=='13'){
				$("#btn_add_banip").click();
				return false;
			}
		});
		
		/* 검색 IP 입력폼 엔터키 */
		$(".search_ip_input input").bind('keydown',function(event){
			if(event.keyCode=='13'){
				$("#btn_search_banip").click();
				return false;
			}
			
			if(event.keyCode=='27'){
				$("#btn_reset_banip").click();
				return false;
			}
		});
		
		/* 보안서버 신청 버튼 */
		$("#btn_ssl_regist").click(function(){
			window.open("https://firstmall.kr/ec_hosting/addservice/ssl.php");
		});
		 
<?php if($TPL_statisticExcludeIp_1){foreach($TPL_VAR["statisticExcludeIp"] as $TPL_V1){?>
		add_banip('<?php echo $TPL_V1?>','append');
<?php }}?>
	});

	function add_banip(ip,loc){
		if(ip.length){
			var html = '';
			html += '<div class="ip_item clearbox">';
			html += '<input type="hidden" name="statisticExcludeIp[]" value="'+ip+'"  >';
			html += '<span class="ip_item_ip">'+ip+'</span>';
			html += '<span class="ip_item_del hand" onclick="del_banip(this)"><img src="/admin/skin/default/images/common/icon_minus.gif" /></span>';
			html += '</div>';
			
			if($("input[name='statisticExcludeIp[]'][value='"+ip+"']").length){
				openDialogAlert("이미 추가한 IP입니다.",400,140);
			}else{
				if(loc=='append')$("#ip_list").append(html);
				if(loc=='prepend')$("#ip_list").prepend(html);
			}
		}
	}

	/* 아이피 삭제 */
	function del_banip(btn){
		$(btn).closest(".ip_item").remove();
	}
</script>
<style>
	#ip_list {margin-top:5px; border:1px solid #ddd; height:120px; padding:5px; overflow:auto;}
	#ip_list .ip_item {height:22px; line-height:22px; border-top:1px dashed #ddd;}
	#ip_list .ip_item:first-child {border-top:0px;}
	#ip_list .ip_item_ip	{float:left;}
	#ip_list .ip_item_del	{float:right; padding-top:2px;}
</style>

<div class="item-title">방문자 통계 수집 제외 IP 설정</div>
<form name="visitorSettingForm" method="post" enctype="multipart/form-data" action="../statistic_process/visitor_setting" target="actionFrame">
<table width="100%" class="info-table-style">
<col width="150" /><col width="" /><col width="150" /><col width="" />
<tr>
	<th class="its-th">설정</th>
	<td class="its-td">
	
		<table>
		<tr>
			<td>
				<span class="desc">현재 접속중인 아이피 : </span><span class="blue"><?php echo $_SERVER["REMOTE_ADDR"]?></span><br /><br />
				<span class="new_ip_input ip_input">
				<input type="text" value="" size="4" class="line" />.
				<input type="text" value="" size="4" class="line" />.
				<input type="text" value="" size="4" class="line" />.
				<input type="text" value="" size="4" class="line" />
				</span>
				<span class="btn small"><input type="button" value="추가" id="btn_add_banip" /></span>
				<br /><br />
				<span class="desc">※ 제외 IP 입력 안내<br />
				123 . 123 . 123 . [공란] 입력 시<br />
				123 . 123 . 123 . 0~255 대역이 모두 제외됨
				</span>
			</td>
			<td width="50" class="center">
				
			</td>
			<td valign="top">
				<b>방문자 통계 수집 제외  IP 리스트</b><br />
				<span class="search_ip_input ip_input">
					<input type="text" value="" size="4" class="line" />.
					<input type="text" value="" size="4" class="line" />.
					<input type="text" value="" size="4" class="line" />.
					<input type="text" value="" size="4" class="line" />
				</span>
				<span class="btn small"><input type="button" value="검색" id="btn_search_banip" /></span>
				<span class="btn small"><input type="button" value="초기화" id="btn_reset_banip" /></span>
				<br />
				<div id="ip_list"></div>					
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<br style="line-height:10px;"/>

<div align="center"><span class="btn medium black"><input type="submit" value="저장" /></span></div>

</form>