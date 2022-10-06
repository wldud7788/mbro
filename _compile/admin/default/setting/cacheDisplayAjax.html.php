<?php /* Template_ 2.2.6 2022/05/17 12:36:55 /www/music_brother_firstmall_kr/admin/skin/default/setting/cacheDisplayAjax.html 000005863 */ ?>
<div class="resp_message mb10">  
   상품디스플레이를 미리 저장해 두어 더 빠른 속도로 페이지를 접속할 수 있게 합니다.
   <span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/cache', '#tip1', 'sizeR')"></span>   
</div>
<table width="100%" class="table_row_basic tdc">
<colgroup>
    <col width="7%" />
    <col width="7%" />
    <col width="20%" />
    <col width="20%" />
    <col width="8%" />
    <col width="8%" />
    <col width="10%" />
    <col width="20%" />
</colgroup>
<thead>
    <tr>
        <th rowspan="2"><span class="icon-star-gray hand" onclick="setAllFavorite(this)" ></span></th>
        <th rowspan="2">번호</th>
        <th rowspan="2">[플랫폼] 영역</th>
        <th rowspan="2">상품디스플레이명</th>                    
        <th colspan="2">캐시파일 생성</th>
        <th rowspan="2">
			캐시파일 사용<br/>
			<span class="tooltip_btn mt5" onClick="showTooltip(this, '/admin/tooltip/cache', '#tip3', '280')"></span>
		</th>
        <th rowspan="2">캐시파일</th>
    </tr>
    <tr>
        <th>
			자동
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/cache', '#tip2', 'sizeM')"></span>
		</th>
        <th>수동 <span class="hand view-goods-display-cach-set-btn resp_btn v2 size_S" onclick="allGoodsDisplayCache();">일괄</span></th>        
    </tr>
</thead>
<tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["display_list"]["record"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
    <tr>        
        <td><span class="icon-star-gray hand <?php if($TPL_V1["favorite"]=='y'){?>checked<?php }?>" onclick="setFavorite(this,{'display_seq':'<?php echo $TPL_V1["display_seq"]?>','display_tab_index':'<?php echo $TPL_V1["display_tab_index"]?>','favorite':'<?php echo $TPL_V1["favorite"]?>'})"></span></td>
        <td><?php echo $TPL_V1["_no"]?></td>
        <td class="left">
            [<?php if($TPL_V1["platform"]=='pc'){?>데스크톱<?php }elseif($TPL_V1["platform"]=='mobile'){?>모바일<?php }elseif($TPL_V1["platform"]=='fammerce'){?>페이스북<?php }elseif($TPL_V1["platform"]=='responsive'){?>반응형<?php }?>] 상품디스플레이
        </td>                    
        <td class="left">
            (<?php echo $TPL_V1["display_seq"]?>)
<?php if($TPL_V1["admin_comment"]){?>
            <?php echo htmlspecialchars($TPL_V1["admin_comment"])?>

<?php }else{?>
            없음
<?php }?>
<?php if($TPL_VAR["display_list"]["record"][$TPL_I1- 1]["display_seq"]==$TPL_V1["display_seq"]||$TPL_VAR["display_list"]["record"][$TPL_I1+ 1]["display_seq"]==$TPL_V1["display_seq"]){?>
            - 탭 <?php echo $TPL_V1["display_tab_index"]+ 1?>

<?php }?>
        </td>
        <td>            
            <label class="resp_checkbox"><input type="checkbox" name="auto_generation[]" value="<?php echo $TPL_V1["display_seq"]?>_<?php echo $TPL_V1["display_tab_index"]?>" onclick="setAutoGeneration(this,{'display_seq':'<?php echo $TPL_V1["display_seq"]?>','display_tab_index':'<?php echo $TPL_V1["display_tab_index"]?>','auto_generation':'<?php echo $TPL_V1["auto_generation"]?>'})" /></label>
            <script type="text/javascript">chkAutoGeneration({'idx':'<?php echo $TPL_I1?>','auto_generation':'<?php echo $TPL_V1["auto_generation"]?>','auto_use':'<?php echo $TPL_V1["auto_use"]?>','cache_use':'<?php echo $TPL_V1["cache_use"]?>','cache_file':'<?php echo $TPL_V1["cache_file"]?>'})</script>
        </td>
        <td class="select_style">
            <div onclick="chgGoodsDisplayCache(this, {'display_seq':'<?php echo $TPL_V1["display_seq"]?>', 'display_tab_index':'<?php echo $TPL_V1["display_tab_index"]?>', 'perpage':'<?php echo $TPL_V1["perpage"]?>', 'kind':'<?php echo $TPL_V1["kind"]?>'});">
<?php if($TPL_V1["auto_use"]!='y'){?>
                <span class="hand goods-display-cach-btn resp_btn">생성</span>
<?php }else{?>
                <span class="link">불가</span>
<?php }?>
            </div>
        </td>
        <td>
            <div onclick="setGoodsDisplayCache(this, {'display_seq':'<?php echo $TPL_V1["display_seq"]?>', 'display_tab_index':'<?php echo $TPL_V1["display_tab_index"]?>', 'perpage':'<?php echo $TPL_V1["perpage"]?>', 'kind':'<?php echo $TPL_V1["kind"]?>'});">
<?php if(!$TPL_V1["cache_file"]){?>
                <span class="link">불가</span>
<?php }else{?>            
<?php if($TPL_V1["cache_use"]=='y'){?>
                <span class="btn-gradient hand view-goods-display-cach-set-btn" style="width:40px;">사용</span>
<?php }else{?>            
                <span class="btn-gradient hand off view-goods-display-cach-set-btn" style="width:40px;">미사용</span>
<?php }?>
<?php }?>
            </div>
        </td>
        <td>
            <div onclick="viewGoodsDisplayCache(this, {'display_seq':'<?php echo $TPL_V1["display_seq"]?>', 'display_tab_index':'<?php echo $TPL_V1["display_tab_index"]?>', 'perpage':'<?php echo $TPL_V1["perpage"]?>', 'kind':'<?php echo $TPL_V1["kind"]?>'});">
<?php if(!$TPL_V1["cache_file"]||$TPL_V1["cache_use"]!='y'){?>
                -
<?php }else{?>
<?php if($TPL_V1["auto_generation"]=='y'){?>
                [자동]
<?php }else{?>
                [수동]
<?php }?>
                <?php echo $TPL_V1["cache_file"]?>

                <span class="link">보기</span>
<?php }?>
            </div>
        </td>
    </tr>                
<?php }}else{?>
    <tr>
        <td colspan="8">검색된 결과가 없습니다.</td>
    </tr>
<?php }?>
</tbody>
</table>
<div class="paging_navigation"><?php echo $TPL_VAR["display_list"]["page"]["html"]?></div>