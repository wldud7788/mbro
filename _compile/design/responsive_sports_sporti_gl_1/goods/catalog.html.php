<?php /* Template_ 2.2.6 2022/07/05 10:33:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/goods/catalog.html 000003121 */  $this->include_("showGoodsSearchFormLight");
$TPL_month_1=empty($TPL_VAR["month"])||!is_array($TPL_VAR["month"])?0:count($TPL_VAR["month"]);
$TPL_today_1=empty($TPL_VAR["today"])||!is_array($TPL_VAR["today"])?0:count($TPL_VAR["today"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "카테고리" 리스트 페이지 @@
- 파일위치 : [스킨폴더]/goods/catalog.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div id="itemstmplayer" class="hide"></div>

<div id="catalog_page">
    <div class="search_nav"></div>

    <!--[ 상단 꾸미기 HTML ]-->
<?php if($TPL_VAR["categoryData"]["top_html"]){?>
    <div class="category_edit_area mobile_img_adjust">
    <?php echo $TPL_VAR["categoryData"]["top_html"]?>

    </div>
<?php }?>

    <!-- ------- 검색필터, 추천상품, 상품정렬( 파일위치 : [스킨폴더]/goods/_search_form_light.html ) ------- -->
    <?php echo showGoodsSearchFormLight()?>

    <!-- ------- //검색필터, 추천상품, 상품정렬 ------- -->

    <!-- ------- 상품 영역( data-displaytype : "lattice", "list" ), 파일위치 : [스킨폴더]/goods/search_list_template.html ------- -->
    <div id="searchedItemDisplay" class="searched_item_display" data-displaytype="lattice"></div>
    <!-- ------- //상품 영역 ------- -->
</div>

<div id="wish_alert">
    <div class="wa_on"></div>
    <div class="wa_off"></div>
    <div class="wa_msg"></div>
</div>

<div class="resp_wrap">
    <div class="title_group1">
        <h3 class="title1"><a href="" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvY2F0YWxvZy5odG1s" hrefOri='' >RANK</a></h3>
    </div>
    <div class="item_img_area">
        이번달 방문자 TOP
        <table>
            <tr>
                <th>순위</th>
                <td>닉네임</td>
            </tr>
<?php if($TPL_VAR["month"]){?>
<?php if($TPL_month_1){foreach($TPL_VAR["month"] as $TPL_V1){?>
                    <tr>
                        <th><?php echo $TPL_V1["id"]?></th>
                        <td><?php echo $TPL_V1["user_name"]?></td>
                    </tr>
<?php }}?>
<?php }else{?>
<?php }?>
        </table>
    </div>
    <div class="item_img_area">
        오늘 방문자 TOP
        <table>
            <tr>
                <th>순위</th>
                <td>닉네임</td>
            </tr>
<?php if($TPL_VAR["today"]){?>
<?php if($TPL_today_1){foreach($TPL_VAR["today"] as $TPL_V1){?>
            <tr>
                <th><?php echo $TPL_V1["id"]?></th>
                <td><?php echo $TPL_V1["user_name"]?></td>
            </tr>
<?php }}?>
<?php }else{?>
<?php }?>
        </table>
    </div>
</div>

<script type="text/javascript">
$(function() {
    // 검색 페이지 -> 디폴트 검색박스 open
    $('#searchModule #searchVer2').show();

    // 컬러 필터 - 255, 255, 255 --> border
    colorFilter_white( '#searchFilterSelected .color_type' );
});
</script>