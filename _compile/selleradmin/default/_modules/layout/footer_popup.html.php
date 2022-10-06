<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/_modules/layout/footer_popup.html 000000745 */ ?>
</div>

<?php if($_SERVER["REMOTE_ADDR"]=='127.0.0.1'){?>
<iframe name="actionFrame" id="actionFrame" src="/data/index.php" frameborder="1" width="100%" height="1000" class="hide"></iframe>
<?php }else{?>
<iframe name="actionFrame" id="actionFrame" src="/data/index.php" frameborder="1" width="100%" height="1000" class="hide"></iframe>
<?php }?>

<div id="openDialogLayer" style="display: none">
	<div align="center" id="openDialogLayerMsg"></div>
</div>

<div id="ajaxLoadingLayer" style="display: none"></div>

</body>
<?php $this->print_("common_html_footer",$TPL_SCP,1);?>