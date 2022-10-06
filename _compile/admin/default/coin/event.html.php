<?php /* Template_ 2.2.6 2022/04/12 11:35:16 /www/music_brother_firstmall_kr/admin/skin/default/coin/event.html 000003281 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<style type="text/css">
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
    <div id="page-title-bar">
        <div class="page-title">
            <h2>뮤직브로 코인전환자</h2>
        </div>
    </div>
</div>
<section>
    <form>
        회원 검색
    </form>
</section>
<section>
    <a href="https://etherscan.io/address/0x73cC01128945928f406C21a5c5256578Ed7bFf6f" target="_blank">지갑 상태 조회</a>
    <div><a href="./download" download="true">다운로드</a></div>
</section>
<!-- 테이블 부분 -->
<section>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>No</th>
            <th>이름</th>
            <th>핸드폰번호</th>
            <th>고객 지갑주소</th>
            <th>금액</th>
            <th>상태</th>
            <th>신청 날짜</th>
            <th>최근 변경날짜</th>
            <th>상태변경</th>
        </tr>
        </thead>
        <tbody>
<?php if($TPL_VAR["list"]){?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
                <tr>
                    <td><?php echo $TPL_V1["id"]?></td>
                    <td><a href="../../admincrm/member/emoney_list?member_seq=<?php echo $TPL_V1["member_seq"]?>" target="_blank"><?php echo $TPL_V1["name"]?></a></td>
                    <td><?php echo $TPL_V1["phone"]?></td>
                    <td><?php echo $TPL_V1["address"]?></td>
                    <td><?php echo $TPL_V1["money"]?></td>
                    <td><?php echo $TPL_V1["user_status"]?></td>
                    <td><?php echo $TPL_V1["created_at"]?></td>
                    <td><?php echo $TPL_V1["updated_at"]?></td>
                    <td><a style="cursor: pointer" onclick="update_status('<?php echo $TPL_V1["id"]?>', '<?php echo $TPL_V1["user_status"]?>')">상태 업데이트</a></td>
                </tr>
<?php }}?>
<?php }else{?>
            전환자가 없습니다.
<?php }?>
        </tbody>
    </table>
</section>
<script>
    function update_status(id, status) {

        if (status == 'wait') {
            var cng = "지급 완료";
            // 캐시 지급 후 진행 요청
        } else if (status == 'comp') {
            var cng = "지급 대기";
        }

        var text = cng+"로 상태를 변경합니다.";

        if (confirm(text) == false) {
            alert("변경을 취소합니다.");
        }

        $.ajax({
            'url': './updateStatus',
            'type': 'post',
            'data': {'id': id , 'status': status},
            success: function (res) {
                alert("변경이 완료되었습니다.");
                location.reload();
            }, error: function (data) {
                alert("에러가 발생하였습니다.");
            }
        });
    }
</script>
<!-- 페이지 타이틀 바 : 끝 -->

<?php $this->print_("layout_footer",$TPL_SCP,1);?>