<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class mubroEvent extends admin_base {
    public function __construct() {
        parent::__construct();
        $this->load->library('validation');
    }

    public function index() {
        $this->admin_menu();
        $this->tempate_modules();

        $file_path	= $this->template_path();
        $this->template->assign('css','common-ui');
        $this->template->define(array('tpl'=>$file_path));
        $this->template->define('member_search',$this->skin.'/member/member_search.html');
        $this->template->print_("tpl");
    }

}
?>