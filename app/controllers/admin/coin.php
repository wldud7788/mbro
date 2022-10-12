<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class coin extends admin_base
{

    public function __construct()
    {
        parent::__construct();

        $this->admin_menu();
        $this->tempate_modules();

        $file_path = $this->template_path();
        define('FILE_PATH', $file_path);

        // 모바일
        $this->template->assign('ismobile', $this->_is_mobile_agent);//ismobile

        //상단 타이틀
        $this->template->define(array('tpl' => FILE_PATH));

        // db 로드
        $this->load->model('coinmodel');
    }

    public function index() {


        $getData = $this->input->get();
        $date = date("Y-m-d");


        if (!$getData) {
            $data = $this->search_list();
            $now = '1';
        } else {
            $data = $this->search($getData);
            $now = $getData['page'];

        }

        $page = $this->paging($getData, $now, $data);

        $this->template->assign('getData', $getData);
        $this->template->assign('date', $date);
        $this->template->assign('list', $data);
        $this->template->print_("tpl");
    }

    public function search($data) {
        $old_type = $data['type'];
        $keyword = $data['keyword'];
        $user_status = $data['user_status'];
        $wait_start = $data['wait_start'];
        $wait_end = $data['wait_end'];
        $comp_start = $data['comp_start'];
        $comp_end = $data['comp_end'];

        if ($wait_start == NULL) {
            $wait_start = date("Y-m-d");
        }

        if ($wait_end == NULL) {
            $wait_end = date("Y-m-d");
        }

        if ($comp_start == NULL) {
            $comp_start = date("Y-m-d");
        }

        if ($comp_end == NULL) {
            $comp_end = date("Y-m-d");
        }

        if ($old_type == 'empty') {
           $new_type  = 'name';
        } else {
            $new_type = $old_type;
        }

        if ($user_status == 'all') {
            $status_where = 'user_status is not null';
        } else {
            $status_where = 'user_status = '.'"'.$user_status.'"';
        }

        $wait = '"'.$wait_start.' 00:00:00 "AND"'.$wait_end.' 23:59:59"';
        $comp = '"'.$comp_start.' 00:00:00 "AND"'.$comp_end.' 23:59:59"';

        $data2 = $this->coinmodel->search_where($new_type, $keyword, $status_where, $wait, $comp);

        return $data2;
    }

    public function paging($getData, $now, $data) {
        $type = array();

        $row = '10';
        $block = '3';

        // 총 전환신청 갯수
        $totalCount = count($data);

        $totalPage = ceil($totalCount/$row); // 총 페이지 수
        $totalBlock = ceil($totalPage/$block); // 총 블럭
        $nowBlock = ceil($now/$block); // 현제 블럭
        $startPage = ($block*$block)-8; // 시작 페이지
        $lastPage = min($totalPage,$nowBlock*$block);

        if ($totalPage<=$lastPage) {
            $lastPage = $totalPage;
        }

        $limitIdx = ($now-1)*$row;

        $prevPage = $now-1;
        $nextPage = $now+1;

        $prevBlock = $block-1; // 이전 페이지
        $nextBlock = $block+1; // 현재 페이지

        if($nextPage>=$totalPage) {
            $nextPage = $totalPage;
        }

        $pageing = array();

        array_push($pageing, array(
            'page' => $now,
            'startPage' => $startPage,
            'lastPage' => $lastPage,
            'nextPage' => $nextPage,
            'prevPage' => $prevPage,
            'pageSet' => $row,
            'limitIdx' => $limitIdx,
            'totalPage' => $totalPage
        ));


    }

    public function search_list()
    {
        $row = $this->coinmodel->admin_search();

        $data = array();
        foreach ($row as $key => $value) {
            $data[] = array(
                'id' => $value['id'],
                'member_seq' => $value['member_seq'],
                'name' => $value['name'],
                'phone' => $value['phone'],
                'email' => $value['email'],
                'address' => $value['address'],
                'money' => $value['money'],
                'user_status' => $value['user_status'],
                'created_at' => $value['created_at'],
                'updated_at' => $value['updated_at']

            );
        }

        return $data;

    }

    public function updateStatus() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if ($status == 'wait') {
            $cng = 'comp';
        } else {
            $cng = 'wait';
        }

        $date = date("Y-m-d H:i:s");


        // db 업데이트
        $data = array('user_status' => $cng, 'updated_at' => $date);
        $where = array('id' => $id);

       $data2 = $this->coinmodel->admin_update('fm_coin_event', $data, $where);
    }

    public function download() {

        $this->load->helper('download');
        // php엑셀 로드
        $this->load->library('PHPExcel');

        // 필요한 데이터
        $data = $this->search_list();

        // 그외 변수
        $today = date("Y-m-d");
        $fileName = $today.'_코인변경자리스트.xls';

        $objExcel = new PHPExcel();
        $objExcel->setActiveSheetIndex(0);

        $headerArr = array(
            'No', '이름', '핸드폰 번호', '지갑주소', '금액', '상태', '신청 날짜', '최근 변경날짜'
        );

        $coin = array();

        foreach ($data as $key => $value) {

            if ($value['user_status'] == 'wait') {
                $status = '입금 대기중';
            } else if ($value['user_status'] == 'comp') {
                $status = '캐시 지급 완료';
            }

            array_push($coin, array(
                'id' => $key,
                'name' => $value['name'],
                'phone' => $value['phone'],
                'address' => $value['address'],
                'money' => $value['money'],
                'status' => $status,
                'created_at' => $value['created_at'],
                'updated_at' => $value['updated_at']
            ));
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
        var_dump($objExcel);
/*
        $objExcel->getActiveSheet()->fromArray($headerArr, NULL, 'A1');
        $objExcel->getActiveSheet()->fromArray($coin, NULL, 'A2');

        header('Content-Disposition: attachment;filename="'.$fileName.'"');

        $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');

        //출력버퍼를 지우고 출력 버퍼링을 종료
        ob_end_clean();

        //출력 버퍼링 시작
        ob_start();

        //브라우져에서 파일로 받는다
        $objWriter->save('php://output');*/
    }
}
?>