<?php /* Template_ 2.2.6 2022/05/17 12:31:53 /www/music_brother_firstmall_kr/admin/skin/default/goods/select_list.html 000007803 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<script type="text/javascript">
function apply_layer(){
	if(!parent)return;
	var iObj = $("#<?php echo $_GET["inputGoods"]?>",parent.document);
	var tag = "";
	$("div#<?php echo $_GET["displayId"]?> div.targetGoods",parent.document).each(function(){
		var goodsSeq = $(this).attr('id');
		var img = $(this).find("div.image").html();
		var goodsName = $(this).find("div.name").text();
		var goodsPrice = $(this).find("div.price").html();
		var eventStNum	= $(this).find("div.event_st_num").html();
<?php if(serviceLimit('H_AD')){?>
		var provider_name	= $(this).find("div.provider_name").html();
<?php }?>

		tag += "<div class='goods fl move'>";
		tag += "<div align='center' class='image'>"+img+"</div>";
		tag += "<div align='center' class='name' style='width:70px;min-height:10px;word-wrap:break-word;'>"+htmlspecialchars(goodsName)+"</div>";
		tag += "<div align='center' class='price'>"+goodsPrice+"</div>";
		tag += "<input type='hidden' name='<?php echo $_GET["inputGoods"]?>[]' value='"+goodsSeq+"' />";
		tag += "<input type='hidden' name='event_st_num[]' value='"+eventStNum+"' />";
<?php if(serviceLimit('H_AD')){?>
		tag += "<div align='center' class='provider_name red'>"+provider_name+"</div>";
<?php }?>
		tag += "</div>";
		this.onclick=function(){parent.targetGoods_click($(this));};
	});
	iObj.html( tag ).promise().done(function(){
		if ('<?php echo $_GET["inputGoods"]?>' == 'distributorGoods') {
			var selectedLength	= $('input[name="<?php echo $_GET["inputGoods"]?>[]"]', parent.document).length
			selectedLength
			$('#countOverDistributorSelected', parent.document).html("총 " + selectedLength + '개의 상품이 선택되었습니다.');
			if (selectedLength > 20) {
				$('#distributorGoods', parent.document).hide();
				$('#countOverDistributorSelected', parent.document).show();
			} else {
				$('#distributorGoods', parent.document).show();
				$('#countOverDistributorSelected', parent.document).hide();
			}
		}
		if ('<?php echo $_GET["inputGoods"]?>' == 'culture_goods') {
			var selectedLength	= $('input[name="<?php echo $_GET["inputGoods"]?>[]"]', parent.document).length;
			parent.$(".naver_count").html("("+selectedLength+"개)");
		}
	});

}

function add_cart(id){
<?php if($_GET["ordertype"]=="person"){?>
	hiddenFrame.location.href = '/admin/order/person_cart?goodsSeq='+id+'&member_seq=<?php echo $_GET["member_seq"]?>';
<?php }else{?>
	hiddenFrame.location.href = '/admin/order/add_cart?goodsSeq='+id+'&member_seq=<?php echo $_GET["member_seq"]?>';
<?php }?>
}

$(function() {

<?php if($_GET["type"]=='select_one_goods'){?>
		$("div#sourceList div.sourceGoods").live("dblclick",function(){
<?php if($_GET["select_one_goods_callback"]){?>
			var goods_seq = $(this).attr('id');
			var select_one_goods_callback = "<?php echo $_GET["select_one_goods_callback"]?>".split("|");
			parent.eval(select_one_goods_callback[0]+"("+select_one_goods_callback[1]+","+goods_seq+")");
<?php }else{?>
			alert('error');
<?php }?>
		});
<?php }else{?>
		$("div#sourceList div.sourceGoods").live("click",function(){
			var cObj = $(this).clone();
			var tObj = $("div#<?php echo $_GET["displayId"]?> div#targetList",parent.document);
			cObj.removeClass("sourceGoods").addClass("targetGoods");
<?php if($_GET["goods_review"]){?>
				$("div#<?php echo $_GET["displayId"]?> div.targetGoods",parent.document).each(function(){
					$(this).parent().empty();
				});
<?php }?>
			if( ! tObj.find("div#"+cObj.attr('id')).length ){
<?php if($_GET["bigdata_test"]== 1){?>
				tObj.html(cObj);
				parent.get_test_list();
<?php }else{?>
				tObj.append(cObj);
<?php }?>
			}
<?php if($TPL_VAR["adminOrder"]=="Y"){?>
			add_cart(cObj.attr('id'))
<?php }else{?>
			apply_layer();
<?php }?>
		});

		// 등록된 상품 선택된 상태로
		if(!parent) return;

		if($("div#<?php echo $_GET["displayId"]?> div#targetList div.targetGoods",parent.document).length==0){
			$("#<?php echo $_GET["inputGoods"]?> div.goods",parent.document).each(function(){

				var init = '<?php echo $_GET["init"]?>';
				if(init=='Y'){
					var clone = $("div#sourceList div.sourceGoods").eq(0).clone();
					var img = $(this).find("div.image").html();
					var name = $(this).find("div.name").html();
					var price = $(this).find("div.price").html();
					var seq = $(this).find("input[name='<?php echo $_GET["inputGoods"]?>[]']").val();
					var tObj = $("div#<?php echo $_GET["displayId"]?> div#targetList",parent.document);
					var provider_name = $(this).find("div.provider_name").html();
					clone.attr('id',seq);
					clone.find("div.image").html(img);
					clone.find("div.name").html(name);
					clone.find("div.price").html(price);
					clone.find("div.provider_name").html(provider_name);
					clone.removeClass("sourceGoods").addClass("targetGoods");
					clone[0].onclick=function(){parent.targetGoods_click(clone);};
					tObj.append(clone);
				}

			});
		}
<?php }?>

<?php if($_GET["bigdata_test"]== 1&&$_GET["bigdata_no"]){?>
		$('.sourceGoods div').eq(0).trigger('click');
<?php }?>
});
</script>

<style>
.sourceGoods {padding:4px; overflow:hidden; cursor:pointer}
.sourceGoods .image {padding-right:4px;}
.sourceGoods .name {display:block; width:300px; overflow:hidden; white-space:nowrap;}
</style>

<div id="sourceList">
<!-- <?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?> -->
<div class="clearbox sourceGoods" id="<?php echo $TPL_V1["goods_seq"]?>" style="border-right:1px solid #aaa;border-left:1px solid #aaa;border-bottom:1px solid #aaa;">
	<div style="float:left;" class="image">
		<img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" class="goodsThumbView" width="50" height="50" />
	</div>
	<div style="float:left;">
	<div class="name"><?php echo htmlspecialchars($TPL_V1["goods_name"])?></div>
	<div class="price"><?php echo get_currency_price($TPL_V1["price"], 3)?></div>
	<div class="event_st_num hide"><?php echo $TPL_V1["event_st_num"]?></div>
<?php if(serviceLimit('H_AD')){?>
	<div class="provider_name red"><?php echo $TPL_V1["provider_name"]?></div>
<?php }?>
	</div>
</div>
<!-- <?php }}?> -->
</div>
<div style="height:5px"></div>
<div align="center">
<?php if($TPL_VAR["page"]["first"]){?>
<a href="select_list?page=<?php echo $TPL_VAR["page"]["first"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>">처음</a>
<?php }?>
<?php if($TPL_VAR["page"]["prev"]){?>
<a href="select_list?page=<?php echo $TPL_VAR["page"]["prev"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>">이전</a>
<?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["page"]["page"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["page"]["nowpage"]==$TPL_V1){?>
<strong><?php echo $TPL_V1?></strong>
<?php }else{?>
<a href="select_list?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>"><?php echo $TPL_V1?></a>
<?php }?>
<?php }}?>
<?php if($TPL_VAR["page"]["next"]){?>
<a href="select_list?page=<?php echo $TPL_VAR["page"]["next"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>">다음</a>
<?php }?>
<?php if($TPL_VAR["page"]["last"]){?>
<a href="select_list?page=<?php echo $TPL_VAR["page"]["last"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>">마지막</a>
<?php }?>
</div>
<br>
<br>
<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>

<iframe name="hiddenFrame" width="100%" height="330" class="hide"></iframe>