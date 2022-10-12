<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * smart ucc 동영상 등록 라이브러리
 * @author Sunha Ryu
 */
class Videouploadlibrary
{
    /**
     * CI 객체
     * @var object
     */
    public $CI;
    
    /**
     * 동영상 업로드 후 redirect될 URL
     * @var string
     */
    public $url;
    
    /**
     * 해당 라이브러리를 호출하는 클래스의 이름
     * @var string
     */
    public $className;
    
    /**
     * 해당 라이브러리를 호출하는 디렉토리의 이름
     * @var string
     */
    public $dirName;
    
    /**
     * 세션에 저장하는 tmpcode 키값
     * @var string
     */
    public $tmpCodeKey;
    
    /**
     * view에서 표시할 동영상 태그의 가로 크기
     * @var int
     */
    private $width;
    
    /**
     * view에서 표시할 동영상 태그의 세로 크기
     * @var int
     */
    private $height;
    
    /**
     * 동영상 등록 후 GET방식으로 전달할 데이터
     * @var array
     */
    private $getParams;
    
    /**
     * 동영상 등록 후 smartucc로 부터 전송받은 데이터
     * @var array
     */
    private $videoParams;
    
    /**
     * 생성자
     */
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('readurl');
        $this->CI->load->helper('common');
        $this->CI->load->helper('javascript');
        $this->CI->load->helper('form');
        $this->CI->load->model('videofiles');
        $this->className = $this->CI->router->fetch_class();
        $this->dirName = $this->CI->router->fetch_directory();
        $this->getParams = array();
        $this->videoParams = array();
        $this->tmpCodeKey = 'videotmpcode';
    }
    
    /**
     * __call method
     */
    public function __call($method, $args) {
        if(method_exists($this, $method)) {
            $initMethod = $this->className . ucfirst($method);
            if(method_exists($this, $initMethod) === true) {
                $this->$initMethod();
            }
            return call_user_func_array(array($this,$method),$args);
        }
    }
    
    /**
     * 관리자-상품상세에서 등록할 때 사용하는 메서드
     */
    private function goodsUpload()
    {
        $this->getParams['goods_seq'] = $this->CI->input->get('no'); // 상품 번호
        $this->getParams['uptype'] = $this->CI->input->get('uptype'); // 업로드 유형 (image : 상품이미지 영역에 노출 / contents : 상품설명 영역에 노출)
    }
    
    /**
     * 게시판에서 등록할 때 사용하는 메서드
     */
    private function boardUpload()
    {
        $this->getParams['seq'] = $this->CI->input->get('seq'); // 게시글 번호
        $this->getParams['id'] = $this->CI->input->get('id'); // 게시판 id
        
        $boardManager = $this->getBoardManager($this->getParams['id']);
        if(empty($boardManager) || empty($boardManager['video_use']) || strtolower($boardManager['video_use']) !== 'y') {
            pageClose("동영상 기능을 사용하지 않는 게시판입니다.");
            exit;
        }
        
        // 게시판의 경우 게시판 관리-동영상 에서 인코딩 설정한 값으로 등록한다.
        $encoding_speed = $boardManager['video_type'];
        $encoding_screen = str_replace("X", "|", $boardManager['video_screen']);
        $this->CI->template->assign("encoding_speed", $encoding_speed);
        $this->CI->template->assign("encoding_screen", $encoding_screen);
    }
    
    /**
     * 동영상을 smart ucc 에 업로드
     */
    protected function upload()
    {
        $setting = array();
        
        $cfg = config_load('goods');
        $setting['company_id'] = $cfg['ucc_id'];
        $setting['client_key'] = $cfg['ucc_key'];
        
        $this->url = get_connet_protocol() . $this->CI->input->server('HTTP_HOST') . "/{$this->dirName}{$this->className}/video_update?" .  http_build_query($this->getParams);
        $setting['url_success1']    = $this->url;
        $setting['url_error1']      = $this->url;
        
        $this->CI->template->assign("setting", $setting);
        $this->CI->template->assign("className", $this->className);
        $this->CI->template->template_dir = FCPATH . 'app/javascript/plugin/smartucc';
        $this->CI->template->define(array('tpl'=>'upload.html'));
        $this->CI->template->print_("tpl");
    }
    
    /**
     * 관리자-상품상세에서 업데이트할 때 사용하는 메서드
     */
    private function goodsUpdate()
    {
        // 업데이트 변수 선언
        $this->initVideoParams();
        
        $goodsParams = array();
        $goodsParams['goods_seq'] = $this->CI->input->get('goods_seq');
        $goodsParams['uptype'] = $this->CI->input->get('uptype');
        $this->videoParams['tmpcode'] = $this->getVideoTmpCode();
        if($this->videoParams['file_key_w'] || $this->videoParams['file_key_i']) {
            // 상품 이미지 영역에 노출일때만 fm_goods 테이블 업데이트
            if($goodsParams['uptype'] === 'image' && $goodsParams['goods_seq']) {
                $this->CI->db->where('goods_seq', $goodsParams['goods_seq'])->update('fm_goods', array(
                    'file_key_w' => $this->videoParams['file_key_w'],
                    'file_key_i' => $this->videoParams['file_key_i'],
                    'videotmpcode' => $this->videoParams['tmpcode'],
                ));
            }
            $this->videoParams['parentseq'] = $goodsParams['goods_seq'];
            $this->videoParams['upkind'] = 'goods';
            $this->videoParams['type'] = $goodsParams['uptype'];
            $this->videoParams['mbseq']	= $this->CI->managerInfo['manager_seq'];
            $this->videoParams['videoseq'] = $this->CI->videofiles->videofiles_write($this->videoParams);
            
            // 동영상 미리보기 사이즈 설정
            // 상품 동영상은 기본 200으로 설정한다.
            $this->width = 200;
            $this->height = 200;
        } else { // 실패
            // 실패시 전송되는 정보
            $error = $this->CI->input->post("error");
            // 오류를 표시하고 window close
            pageClose("Error : " . $error);
            exit;
        }
    }
    
    /**
     * 게시판에서 업데이트할 때 사용하는 메서드
     */
    private function boardUpdate()
    {
        // 업데이트 변수 선언
        $this->initVideoParams();
        
        $boardParams = array();
        $boardParams['boardid'] = $this->CI->input->get('id'); // 게시판 id
        $boardParams['seq'] = $this->CI->input->get('seq'); // 글 번호
        
        $this->loadBoardModel($boardParams['boardid']);
        
        $this->tmpCodeKey = 'boardvideotmpcode';
        $this->videoParams['tmpcode'] = $this->getVideoTmpCode();
        
        if($this->videoParams['file_key_w'] || $this->videoParams['file_key_i']) {
            
            // 게시글 수정시
            if($boardParams['seq']) {
                $this->CI->Boardmodel->data_modify(array(
                    'file_key_w' => $this->videoParams['file_key_w'],
                    'file_key_i' => $this->videoParams['file_key_i'],
                    'seq' => $boardParams['seq'],
                ));
                $this->videoParams['parentseq'] = $boardParams['seq'];
            } else {
                $this->videoParams['parentseq'] = null;
            }
            $this->videoParams['upkind'] = 'board';
            $this->videoParams['type'] = $boardParams['boardid'];
            $this->videoParams['mbseq']	= $this->CI->managerInfo['manager_seq'];
            $this->videoParams['videoseq'] = $this->CI->videofiles->videofiles_write($this->videoParams);
            
            // 동영상 미리보기 사이즈 설정
            if( $this->CI->_is_mobile_agent ){
                $boardManager = $this->getBoardManager($boardParams['boardid']);
                $this->width = 150;
                $this->height = 100;
                if(!empty($boardManager['video_size_mobile0'])) {
                    $this->width = $boardManager['video_size_mobile0'];
                }
                if(!empty($boardManager['video_size_mobile1'])) {
                    $this->height = $boardManager['video_size_mobile1'];
                }
                $this->videoParams['pageurl'] .= "&width={$this->width}&height={$this->height}";
                
            } else {
                $this->width = 150;
                $this->height = 150;
            }
            
        } else {
            // 실패시 전송되는 정보
            $error = $this->CI->input->post("error");
            // 오류를 표시하고 window close
            pageClose("Error : " . $error);
            exit;
        }
    }
    
    /**
     * 업로드된 동영상 업데이트
     */
    private function update()
    {
        return $this->view();
    }
    
    /**
     * 관리자-상품상세 업데이트 후 화면 처리
     */
    private function goodsView()
    {
        $this->CI->template->assign('width', ((int)$this->width) . 'px');
        $this->CI->template->assign('height', ((int)$this->height) . 'px');
        $this->CI->template->assign('videoseq', $this->videoParams['videoseq']);
        $this->CI->template->assign('uptype', $this->videoParams['type']);
        $this->CI->template->assign('videotmpcode', $this->videoParams['tmpcode']);
        $this->CI->template->assign('pageurl', $this->videoParams['pageurl']);
        $this->CI->template->assign('thumbnail', $this->videoParams['thumbnail']);
        $this->CI->template->assign('file_key_w', $this->videoParams['file_key_w']);
        $this->CI->template->assign('file_key_i', $this->videoParams['file_key_i']);
        $this->CI->template->assign('r_date', $this->videoParams['r_date']);
        
        $this->CI->template->template_dir = FCPATH . 'app/javascript/plugin/smartucc/goods';
        $this->CI->template->define(array('tpl'=>'view.html'));
        $html = $this->CI->template->fetch("tpl");
        $html = json_encode($html);
        if($this->videoParams['type'] === 'image') {
            $script = <<<EOT
window.opener.$("#videofiles_tables_nonetd_img").remove();
window.opener.$("table.videofiles_tables_images").append({$html});
EOT;
        } else {
            $script = <<<EOT
window.opener.$("#videofiles_tables_nonetd").remove();
window.opener.$("table.videofiles_tables").append({$html});
EOT;
        }
        $script .= "window.self.close();";
        echo js($script);
        return true;
    }
    
    /**
     * 게시판에서 업데이트 후 화면 처리
     */
    private function boardView()
    {
        $this->CI->template->assign('width', ((int)$this->width) . 'px');
        $this->CI->template->assign('height', ((int)$this->height) . 'px');
        $this->CI->template->assign('file_key_w', $this->videoParams['file_key_w']);
        $this->CI->template->assign('file_key_i', $this->videoparams['file_key_i']);
        $this->CI->template->assign('pageurl', $this->videoParams['pageurl']);
        
        $this->CI->template->template_dir = FCPATH . 'app/javascript/plugin/smartucc/board';
        $this->CI->template->define(array('tpl'=>'view.html'));
        $html = $this->CI->template->fetch("tpl");
        $html = json_encode($html);
        
        $script = <<<EOT
window.opener.$("#boardVideolay").html({$html});
window.self.close();
EOT;
        echo js($script);
        return true;
    }
    
    /**
     * DB 업데이트 후 화면 처리
     */
    private function view()
    {
        if(!empty($this->videoParams['videoseq']) && !empty($this->videoParams['upkind'])) {
            if(method_exists($this, $this->videoParams['upkind'] . 'View')) {
                return $this->{$this->videoParams['upkind'] . 'View'}();
            }
        }
        return false;
    }
    
    
    /**
     * 업데이트 전 smartucc로 부터 전달받은 데이터를 변수로 선언
     */
    private function initVideoParams()
    {
        $this->videoParams = array();
        $this->videoParams['r_date'] = date("Y-m-d H:i:s");
        $this->videoParams['file_key_w'] = $this->CI->input->post('file_key_W');
        $this->videoParams['file_key_i'] = $this->CI->input->post('file_key_I');
        
        if($this->videoParams['file_key_w'] || $this->videoParams['file_key_i']) {
            $encoding_speed = $this->CI->input->post('encoding_speed');
            $encoding_screen = $this->CI->input->post('encoding_screen');
            $this->videoParams['memo'] = $this->CI->input->post('memo');
            $this->videoParams['encoding_speed'] = ($encoding_speed)?$encoding_speed:400;
            $this->videoParams['encoding_screen'] = ($encoding_screen)?str_replace("|","X",$encoding_screen):'400X300';
            
            $videoInfo = readurl(uccdomain('fileinfo',$this->videoParams['file_key_w']));
            if($videoInfo){
                $videoInfoArray = xml2array($videoInfo);
                $this->videoParams['playtime'] = ($videoInfoArray['class']['playtime'])?$videoInfoArray['class']['playtime']:'';
            }
            $this->videoParams['pageurl'] = uccdomain('fileurl',$this->videoParams['file_key_w']);
            $this->videoParams['thumbnail'] = uccdomain('thumbnail',$this->videoParams['file_key_w']);
        }
    }
    
    /**
     * 등록코드를 반환한다.
     * @return string
     */
    private function getVideoTmpCode()
    {
        $videotmpcode = $this->CI->session->userdata($this->tmpCodeKey);
        if(!$videotmpcode) {
            $videotmpcode = substr(microtime(), 2, 8);
            $this->CI->session->set_userdata($this->tmpCodeKey,$videotmpcode);
        }
        return $videotmpcode;
    }
    
    /**
     * 게시판 관리 정보를 가져온다.
     * @param string $id
     */
    private function getBoardManager($id)
    {
        $this->CI->load->model('Boardmanager');
        $sc = array();
        $sc['whereis']	= ' and id='.$this->CI->db->escape($id);
        $sc['select']		= ' * ';
        return $this->CI->Boardmanager->managerdataidck($sc);
    }
    
    /**
     * board id에 맞는 model을 로드한다.
     * @param string $boardid
     */
    private function loadBoardModel($boardid)
    {
        switch($boardid) {
            case 'goods_qna':
                $this->CI->load->model('Goodsqna','Boardmodel');
                break;
            case 'goods_review':
                $this->CI->load->model('Goodsreview','Boardmodel');
                break;
            case 'bulkorder':
                $this->CI->load->model('Boardbulkorder','Boardmodel');
                break;
            default:
                $this->CI->load->model('Boardmodel');
        }
    }
}