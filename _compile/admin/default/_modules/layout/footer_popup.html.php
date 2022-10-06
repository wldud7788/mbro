<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/_modules/layout/footer_popup.html 000001236 */ ?>
</div>

<iframe name="actionFrame" id="actionFrame" src="/main/blank" frameborder="0" width="100%" <?php if($_GET["debug"]== 1){?>height="600"<?php }else{?>height="0"<?php }?>  <?php if($TPL_VAR["barcodeprint"]== 1){?> class="hide" <?php }?> ></iframe>

<div id="main_demo" class="hide"></div>
<div id="openDialogLayer" style="display: none">
	<div align="center" id="openDialogLayerMsg"></div>
</div>

<div id="ajaxLoadingLayer" style="display: none"></div>

<div id="noliteService" class="hide">
<div>
		<table width="100%">
		<tr>
		<td align="left">
			입점몰+ Lite 에서는 해당기능이 지원되지 않습니다.<br />
			입점몰+ 로 업그레이드 하시길 바랍니다.<br />
		</td>
		</tr>
		<tr>
		<td align="center"><br /><br />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<img src="/admin/skin/default/images/common/btn_upgrade.gif" class="hand" onclick="serviceUpgrade();" align="absmiddle" />
		</td>
		</tr>
		</table>
	</div>
	<br style="line-height:20px;" />
</div>

</body>
<?php $this->print_("common_html_footer",$TPL_SCP,1);?>