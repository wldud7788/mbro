<?php /* Template_ 2.2.6 2021/08/25 16:20:49 /www/music_brother_firstmall_kr/selleradmin/skin/default/board/_score.html 000007204 */ ?>
<?php if($TPL_VAR["managerview"]["auth_recommend_use"]=='Y'){?>
<div >
<?php if($TPL_VAR["managerview"]["recommend_type"]=='3'){?> 
		<table style="width:300px;margin:auto;border:0px dashed black;padding:5px;"> 
			<tbody >
			<tr  align="center">  
				<td>
					<div><span class=" idx-recommend1-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_VAR["recommend1"])?></span></div>
					<div><span class="icon_recommend1_<?php echo $TPL_VAR["seq"]?>_lay<?php echo $TPL_VAR["is_recommend"]?>  icon_recommend1_lay<?php echo $TPL_VAR["is_recommend"]?> hand"  board_recommend="recommend1"   board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" ><img src="<?php echo $TPL_VAR["managerview"]["icon_recommend1_src"]?>" class="icon_recommend1_img" /></span></div>
					<div <?php if($TPL_VAR["is_recommend"]){?> class="hide" <?php }?> style="margin-top:5px;"><span class="icon_recommend1_lay<?php echo $TPL_VAR["is_recommend"]?>  input-recommend-<?php echo $TPL_VAR["seq"]?> hand"   board_recommend="recommend1" ><input type="radio" name="input-recommend[<?php echo $TPL_VAR["seq"]?>]"   /></span></div>
				</td>
				<td>
					<div><span class=" idx-recommend2-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_VAR["recommend2"])?></span></div>
					<div><span class="icon_recommend2_<?php echo $TPL_VAR["seq"]?>_lay<?php echo $TPL_VAR["is_recommend"]?>  icon_recommend2_lay<?php echo $TPL_VAR["is_recommend"]?> hand"  board_recommend="recommend2"   board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" ><img src="<?php echo $TPL_VAR["managerview"]["icon_recommend2_src"]?>" class="icon_recommend2_img" /></span></div>
					<div <?php if($TPL_VAR["is_recommend"]){?> class="hide" <?php }?> style="margin-top:5px;"><span class="icon_recommend2_lay<?php echo $TPL_VAR["is_recommend"]?>  input-recommend-<?php echo $TPL_VAR["seq"]?> hand"   board_recommend="recommend2" ><input type="radio"  name="input-recommend[<?php echo $TPL_VAR["seq"]?>]" /></span></div>
				</td>
				<td>
					<div><span class=" idx-recommend3-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_VAR["recommend3"])?></span></div>
					<div><span class="icon_recommend3_<?php echo $TPL_VAR["seq"]?>_lay<?php echo $TPL_VAR["is_recommend"]?>  icon_recommend3_lay<?php echo $TPL_VAR["is_recommend"]?> hand"  board_recommend="recommend3"   board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" ><img src="<?php echo $TPL_VAR["managerview"]["icon_recommend3_src"]?>" class="icon_recommend3_img" /></span></div>
					<div <?php if($TPL_VAR["is_recommend"]){?> class="hide" <?php }?> style="margin-top:5px;"><span class="icon_recommend3_lay<?php echo $TPL_VAR["is_recommend"]?>  input-recommend-<?php echo $TPL_VAR["seq"]?> hand"   board_recommend="recommend3" ><input type="radio"  name="input-recommend[<?php echo $TPL_VAR["seq"]?>]" /></span></div>
				</td>
				<td>
					<div><span class=" idx-recommend4-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_VAR["recommend4"])?></span></div>
					<div><span class="icon_recommend4_<?php echo $TPL_VAR["seq"]?>_lay<?php echo $TPL_VAR["is_recommend"]?>  icon_recommend4_lay<?php echo $TPL_VAR["is_recommend"]?> hand"  board_recommend="recommend4"   board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" ><img src="<?php echo $TPL_VAR["managerview"]["icon_recommend4_src"]?>" class="icon_recommend4_img" /></span></div>
					<div <?php if($TPL_VAR["is_recommend"]){?> class="hide" <?php }?> style="margin-top:5px;"><span class="icon_recommend4_lay<?php echo $TPL_VAR["is_recommend"]?>  input-recommend-<?php echo $TPL_VAR["seq"]?> hand"   board_recommend="recommend4" ><input type="radio"  name="input-recommend[<?php echo $TPL_VAR["seq"]?>]" /></span></div>
				</td>
				<td>
					<div><span class=" idx-recommend5-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_VAR["recommend5"])?></span></div>
					<div><span class="icon_recommend5_<?php echo $TPL_VAR["seq"]?>_lay<?php echo $TPL_VAR["is_recommend"]?>  icon_recommend5_lay<?php echo $TPL_VAR["is_recommend"]?> hand"  board_recommend="recommend5"   board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" ><img src="<?php echo $TPL_VAR["managerview"]["icon_recommend5_src"]?>" class="icon_recommend5_img" /></span></div>
					<div <?php if($TPL_VAR["is_recommend"]){?> class="hide" <?php }?> style="margin-top:5px;"><span class="icon_recommend5_lay<?php echo $TPL_VAR["is_recommend"]?>  input-recommend-<?php echo $TPL_VAR["seq"]?> hand"   board_recommend="recommend5" ><input type="radio"  name="input-recommend[<?php echo $TPL_VAR["seq"]?>]" /></span></div>
				</td>
			</tr>
		</tbody>
		</table>
<?php }elseif($TPL_VAR["managerview"]["recommend_type"]=='2'){?> 
<?php if($TPL_VAR["managerview"]["icon_recommend_src"]&&$TPL_VAR["managerview"]["icon_none_rec_src"]){?>
		<table style="width:100px;margin:auto;border:0px dashed black;padding:5px;"> 
			<tbody >
			<tr align="center"> 
				<td >
					<span class="icon_recommend_<?php echo $TPL_VAR["seq"]?>_lay<?php echo $TPL_VAR["is_recommend"]?> icon_recommend_lay<?php echo $TPL_VAR["is_recommend"]?> hand"  board_recommend="recommend"   board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" ><img src="<?php echo $TPL_VAR["managerview"]["icon_recommend_src"]?>" class="icon_recommend_img" /></span>
				</td>
				<td><span class="idx-recommend-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_VAR["recommend"])?></span></td>  
				<td><span class="icon_none_rec_<?php echo $TPL_VAR["seq"]?>_lay<?php echo $TPL_VAR["is_recommend"]?>  icon_none_rec_lay<?php echo $TPL_VAR["is_recommend"]?> hand"  board_recommend="none_rec"   board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" ><img src="<?php echo $TPL_VAR["managerview"]["icon_none_rec_src"]?>"  class="icon_none_rec_img"  /></span></td>
				<td><span class=" idx-none_rec-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_VAR["none_rec"])?></span></td> 
			</tr>
		</tbody>
		</table> 
<?php }?> 
<?php }elseif($TPL_VAR["managerview"]["recommend_type"]=='1'){?> 
<?php if($TPL_VAR["managerview"]["icon_recommend_src"]){?>
		<table style="width:50px;margin:auto;border:0px dashed black;padding:5px;"> 
			<tbody >
			<tr align="center"> 
				<td >
					<span class="icon_recommend_<?php echo $TPL_VAR["seq"]?>_lay<?php echo $TPL_VAR["is_recommend"]?> icon_recommend_lay<?php echo $TPL_VAR["is_recommend"]?> hand"  board_recommend="recommend"  board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" ><img src="<?php echo $TPL_VAR["managerview"]["icon_recommend_src"]?>" class="icon_recommend_img" /></span>
				</td>
				<td><span class=" idx-recommend-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_VAR["recommend"])?></span></td>  
			</tr>
		</tbody>
		</table> 
<?php }?>
<?php }?>
</div>
<?php }?>