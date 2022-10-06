<?php /* Template_ 2.2.6 2022/07/12 16:04:10 /www/music_brother_firstmall_kr/admin/skin/default/coin/index.html 000008865 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>



<!--부트스트랩 호출-->
<!--
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
-->
<!-- 페이지 타이틀 바 : 시작 -->
<style type="text/css">
    .coin_title{text-align: center; margin-bottom: 10px; margin-top: 30px;}
    .coin_search_table{margin: 0 auto; line-height: 35px;}
    .coin_search_table tr th{text-align: left; padding-right: 15px; box-sizing: border-box;}
    .coin_search_table tr td input{padding: 4px;}
    .coin_search_btn_box{text-align: center; margin-top: 10px; margin-bottom: 50px;}
    .coin_search_btn_box>button{padding: 5px; width: 45px; height: 30px; background: url(/admin/skin/default/images/common/icon/admin_search_bt.gif) no-repeat center center; border: none; cursor: pointer;}
    .coin_search_btn_box>button:hover{opacity: 0.8;}
    .coin_reset_btn_box{display: inline-block; vertical-align: top;}
    .coin_reset_btn_box button{padding: 5px; height: 30px; cursor: pointer;}
    .coin_wallet_box{display: inline-block; vertical-align: top;}
    .coin_wallet_box a{display: block; line-height: 17px; padding: 5px; height: 30px; border: 1px solid #444444; box-sizing: border-box; background-color: #EEEEEE; color: #444444; border-radius: 3px;}
    .coin_wallet_box a:hover{background-color: #E5E5E5;}

    .coin_list_table{margin: 0 auto; border: 1px solid #444444; border-collapse: collapse;}
    .coin_list_table tr th, .coin_list_table tr td{border: 1px solid #444444; padding: 10px 30px; box-sizing: border-box;}
</style>

<div id="page-title-bar-area">
    <div id="page-title-bar">
        <div class="page-title">
            <h2>BMP코인 전환자 확인</h2>
        </div>
    </div>
</div>


<!-- 조회 폼-->
<section>
    <div>
        <h1 class="coin_title">회원 검색</h1>
        <form name="bmpCoinFrm" name="bmpCoinFrm" method="get">
            <table class="coin_search_table">
                <tr>
                    <th>검색어</th>
                    <td>
                        <select name="type">
                            <option value="empty" <?php if($TPL_VAR["getData"]["type"]=='empty'){?> selected="selected"<?php }?> >전체</option>
                            <option value="name"<?php if($TPL_VAR["getData"]["type"]=='name'){?> selected="selected"<?php }?>>이름</option>
                            <option value="address"<?php if($TPL_VAR["getData"]["type"]=='address'){?> selected="selected"<?php }?>>지갑주소</option>
                            <option value="phone"<?php if($TPL_VAR["getData"]["type"]=='phone'){?> selected="selected"<?php }?>>핸드폰번호</option>
                        </select>
                        <input type="text" name="keyword" <?php if($TPL_VAR["getData"]["keyword"]){?> value="<?php echo $TPL_VAR["getData"]["keyword"]?>"<?php }?> >
                    </td>
                </tr>
                <tr>
                    <th>상태</th>
                    <td>
                        <select name="user_status">
                            <option value="all" <?php if($TPL_VAR["getData"]["user_status"]=='all"'){?> selected="selected"<?php }?>>전체</option>
                            <option value="wait" <?php if($TPL_VAR["getData"]["user_status"]=='wait'){?> selected="selected"<?php }?>>입금 대기</option>
                            <option value="comp" <?php if($TPL_VAR["getData"]["user_status"]=='comp'){?> selected="selected"<?php }?>>지급 완료</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>신청기간 조회</th>
                    <td>
                        <input type="date" name="wait_start" <?php if($TPL_VAR["getData"]["wait_start"]!=''){?> value="<?php echo $TPL_VAR["getData"]["wait_start"]?>" <?php }else{?> value="<?php echo $TPL_VAR["date"]?>" <?php }?> >  ~
                        <input type="date" name="wait_end" <?php if($TPL_VAR["getData"]["wait_end"]!=''){?> value="<?php echo $TPL_VAR["getData"]["wait_end"]?>" <?php }else{?> value="<?php echo $TPL_VAR["date"]?>" <?php }?> >
                    </td>
                </tr>
                <tr>
                    <th>정보 업데이트 조회</th>
                    <td>
                        <input type="date" name="comp_start" <?php if($TPL_VAR["getData"]["comp_start"]!=''){?> value="<?php echo $TPL_VAR["getData"]["comp_start"]?>" <?php }else{?> value="<?php echo $TPL_VAR["date"]?>" <?php }?>> ~
                        <input type="date" name="comp_end" <?php if($TPL_VAR["getData"]["comp_end"]!=''){?> value="<?php echo $TPL_VAR["getData"]["comp_end"]?>" <?php }else{?> value="<?php echo $TPL_VAR["date"]?>" <?php }?>>
                    </td>
                </tr>
            </table>
            <div class="coin_search_btn_box">
                
                 <!-- 지갑 상태 조회 -->
                <div class="coin_wallet_box">
                    <a href="https://etherscan.io/address/0xD2350079A4222650065C9a2D8b096cb997347E27" target="_blank">지갑 상태 조회</a>
                    <!--<div><a href="./download" download="true">다운로드</a></div>-->
                </div>

                <!-- 처음으로 돌아가기 -->
                <div class="coin_reset_btn_box">
                    <button type="button" id="reset" onclick="reset_page()">처음으로 되돌리기</button>
                    <!-- <button type="reset" >초기화</button> -->
                </div>

                <button type="submit" ></button>

               
            </div>
        </form>
    </div>
</section>


<!-- 리스트 조회 부분 -->
<section>
    <table class="table table-hover coin_list_table">
        <thead>
        <tr>
            <th>No</th>
            <th>이름</th>
            <th>핸드폰번호</th>
            <th>고객 지갑주소</th>
            <th>입금예정 금액</th>
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
                    <td><?php if($TPL_V1["user_status"]=='wait'){?> 입금 대기 <?php }else{?> 지급 완료 <?php }?> </td>
                    <td><?php echo $TPL_V1["created_at"]?></td>
                    <td><?php echo $TPL_V1["updated_at"]?></td>
                    <td><a style="cursor: pointer" onclick="update_status('<?php echo $TPL_V1["id"]?>', '<?php echo $TPL_V1["user_status"]?>')" class="btn btn-default" role="status_update">상태 업데이트</a></td>
                </tr>
<?php }}?>
<?php }else{?>
            검색기록이 없습니다.
<?php }?>
        </tbody>
    </table>
    <div role="pageBtn">
        <button>◀</button>
        <button>현재페이지</button>
        <button>▶</button>
    </div>
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
            
        } else {
            $.ajax({
                'url': './updateStatus',
                'type': 'post',
                'data': {'id': id , 'status': status},
                success: function (res) {
                    alert("변경이 완료되었습니다.");
                    location.reload();
                }, error: function (data) {
                    //console.log(data);
                    alert("에러가 발생하였습니다.");
                }
            });
        }

    }

    function reset_page() {
        location.replace('../coin/index');
    }
</script>
<!-- 페이지 타이틀 바 : 끝 -->

<?php $this->print_("layout_footer",$TPL_SCP,1);?>