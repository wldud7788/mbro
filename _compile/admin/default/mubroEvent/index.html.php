<?php /* Template_ 2.2.6 2022/02/14 15:22:38 /www/music_brother_firstmall_kr/admin/skin/default/mubroEvent/index.html 000002072 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/js/batch.js?v=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('YmdHis')?>"></script>

<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common-ui.css?mm=<?=date('Ymd')?>" />

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
    <div id="page-title-bar">

        <!-- 타이틀 -->
        <div class="page-title">
            <h2>자체 이벤트(가칭)</h2>
        </div>

        <!-- 우측 버튼 -->
        <ul class="page-buttons-right">
            <li></li>
        </ul>
    </div>
</div>
<div class="search_container">
    <div class="search_container">
        <form>
                <table class="table_search">
                    <tbody>
                    <tr>
                        <th>검색어</th>
                        <td>
                            <input type="text" name="form_search">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            검색종류
                        </th>
                        <td>
                            <select>
                                <option id="1" name="all">전체</option>
                                <option id="2" name="event_name">이벤트명</option>
                                <option id="3" name="user_name">유저 이름</option>
                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>
            <span class="search">
                <button type="button" class="search_submit resp_btn active size_XL">검색</button>
            </span>
        </form>
    </div>
</div>