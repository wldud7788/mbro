<?php /* Template_ 2.2.6 2022/05/10 16:26:05 /www/music_brother_firstmall_kr/admin/skin/default/goods/_gl_lastselect_category.html 000004910 */ 
$TPL_last_categories_1=empty($TPL_VAR["last_categories"])||!is_array($TPL_VAR["last_categories"])?0:count($TPL_VAR["last_categories"]);?>
<script type="text/javascript" src="/app/javascript/plugin/jquery_pagination/jquery.pager.js" charset="utf8"></script>
<script>
$(function(){
    /**
    * 페이징 클릭시 페이지를 로딩한다.
    * @param int page 페이지번호
    */
    var pageClick = function(destPage) {
        getAjaxList(destPage);
    }
    
    /**
    * 상품을 ajax로 검색한다.
    * @param int page 페이지번호
    */

    var getAjaxList = function(page) {

        var pageNumber	= page > 0 ? page : 1;
        var queryString = $("#goods_search_container").length > 0 ? $("#goods_search_container form[name='<?php echo $TPL_VAR["sc"]["categoryType"]?>ConnectFrm']").serialize() : $("form[name='<?php echo $TPL_VAR["sc"]["categoryType"]?>ConnectFrm']").serialize();
        var perpage		= 10;

        $.ajax({
            type	: 'post',
            url		: '/admin/goods/gl_lastselect_data',
            data	: queryString+'&page='+page,
            dataType: 'json',
            success	: function(res) {

                var html = '';

                if(res.content.length > 0){
                    $(".lastCategorySelect .datanothing").addClass("hide");
                }else{
                    $(".lastCategorySelect .datanothing").removeClass("hide");
                }
                $(".lastCategorySelect table tbody tr").not("tr.datanothing").remove();

                $.each(res.content, function(key, data){
                    html = '';
                    html += '<tr>';
                    html += '<td class="center"><label class="resp_checkbox"><input type="checkbox" name="'+res.categoryType+'LastRegist[]" class="chk" value="'+data.category_code+'}"></label></th>';
                    html += '<td class="left">'+data.title+'</td>';
                    html += '</tr>';
                    $('#ajaxTable').append(html);
                });

                $(".lastCategorySelect #pager").pager({ pagenumber: res.nowpage, pagecount: res.pagecount, buttonClickCallback: pageClick });
            }
        });
    }

	getAjaxList();
});
</script>

<div class="content lastCategorySelect">
	<form name="<?php echo $TPL_VAR["sc"]["categoryType"]?>ConnectFrm" method="post" action="../goods_process/<?php echo $TPL_VAR["sc"]["categoryType"]?>_connect" target="actionFrame">
    <input type="hidden" name="categoryType" value="<?php echo $TPL_VAR["sc"]["categoryType"]?>" />
    <input type="hidden" name="provider_seq" value="<?php echo $TPL_VAR["sc"]["provider_seq"]?>" />
    <input type="hidden" name="<?php echo $TPL_VAR["sc"]["categoryType"]?>InputMethod" value="lastSelect">
    <table class="table_basic">
        <colgroup>
            <col width="10%" />
            <col width="90%" />
        </colgroup>
        <thead>
            <tr>
                <th><label class="resp_checkbox"><input type="checkbox" name="chkAll" onClick="gCategorySelect.setCheckAll();"></label></th>
                <th><?php echo $TPL_VAR["sc"]["categoryTitle"]?></th>
            </tr>
        </thead>
        <tbody id="ajaxTable">
<?php if($TPL_VAR["last_categories"]){?>
<?php if($TPL_last_categories_1){foreach($TPL_VAR["last_categories"] as $TPL_V1){?>
        <tr>
<?php if($TPL_VAR["sc"]["categoryType"]=="brand"){?>
            <td class="center"><label class="resp_checkbox"><input type="checkbox" name="brandLastRegist[]" class="chk" value="<?php echo $TPL_V1["category_code"]?>"></label></th>
<?php }elseif($TPL_VAR["sc"]["categoryType"]=="location"){?>
            <td class="center"><label class="resp_checkbox"><input type="checkbox" name="locationLastRegist[]" class="chk" value="<?php echo $TPL_V1["category_code"]?>"></label></th>
<?php }else{?>
            <td class="center"><label class="resp_checkbox"><input type="checkbox" name="categoryLastRegist[]" class="chk" value="<?php echo $TPL_V1["category_code"]?>"></label></th>
<?php }?>
            <td class="left"><?php echo $TPL_V1["title"]?></th>
        </tr>
<?php }}?>
<?php }else{?>
        <tr class="datanothing">
            <td class="center" colspan="2">최근 연결 <?php echo $TPL_VAR["sc"]["categoryTitle"]?>(이)가 없습니다.</td>
        </tr>
<?php }?>
        </tbody>
    </table>
    <div id="pager" class="paging_navigation center"></div>
    </form>
</div>
<div class="footer">
    <button type="button" class="confirmSelectCategory resp_btn active size_XL"  data-opt='<?php echo $TPL_VAR["scObj"]?>' >선택</button>
    <button type="button" class="btnLayClose resp_btn v3 size_XL">취소</button>
</div>