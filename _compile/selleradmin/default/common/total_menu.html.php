<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/common/total_menu.html 000002323 */ 
$TPL_adminMenu_1=empty($TPL_VAR["adminMenu"])||!is_array($TPL_VAR["adminMenu"])?0:count($TPL_VAR["adminMenu"]);?>
<script>
	$(function(){
		var docW = $(document).width();
		var marginW = 200;
		$(".pannel").css('width', docW - marginW);
		$(".pannel").css('left', marginW/2);
	
		$(".closeBtn").on("click", function(){
			$(this).closest("body").find(".dialog").hide();
			$("html").css('overflow-y', 'auto');
		})
	});
	</script>
	
	<div class="dim"></div>
	<div class="pannel">
		<div class="closeBtn"><img src="/admin/skin/default/images/common/dialog_close.png"/></div>
		<div class="menu_wrap">	
			<ul>
<?php if($TPL_adminMenu_1){foreach($TPL_VAR["adminMenu"] as $TPL_V1){?>				
				<li>
					<ul class="menu">								
						<li class="depth1"><a href="<?php echo $TPL_V1["url"]?>"><?php echo $TPL_V1["name"]?></a></li>
<?php if(is_array($TPL_R2=$TPL_V1["submenu"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>	
<?php if($TPL_V2["childs"][ 1]){?>	
						<li class="depth2"><?php echo $TPL_V2["name"]?></li>													
<?php if(is_array($TPL_R3=$TPL_V2["childs"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>											
<?php if($TPL_I3> 0){?>										
						<li class="depth3">									
<?php if($TPL_V2["limit"]&&serviceLimit($TPL_V3["limit"],'return')){?>
							<a href="#" onclick="<?php echo serviceLimit($TPL_V3["limit"])?>">- <?php echo $TPL_V3["name"]?></a>
<?php }else{?>
							<a href="<?php echo $TPL_V3["url"]?>">- <?php echo $TPL_V3["name"]?></a>
<?php }?>
						</li>
<?php }?>
<?php }}?>																										
<?php }else{?>
<?php if(is_array($TPL_R3=$TPL_V2["childs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>	
															
						<li class="depth2">									
<?php if($TPL_V2["limit"]&&serviceLimit($TPL_V3["limit"],'return')){?>
							<a href="#" onclick="<?php echo serviceLimit($TPL_V3["limit"])?>"><?php echo $TPL_V3["name"]?></a>
<?php }else{?>
							<a href="<?php echo $TPL_V3["url"]?>"><?php echo $TPL_V3["name"]?></a>
<?php }?>
						</li>
<?php }}?>
					
<?php }?>
<?php }}?>						
					</ul>
				</li>
<?php }}?>		
			</ul> 
		</div>
	</div>