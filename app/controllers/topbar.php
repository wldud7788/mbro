<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class topbar extends front_base {
	public function index()
	{
		$getParams = $this->input->get();
		$tpl = isset($getParams['no']) ? 'main/' . $getParams['no'] : '';
		$layoutPath = check_display_skin_file($this->skin, $tpl);
		if ($layoutPath === false) {
			show_error(getAlert('et001'));
		}

		if($this->designMode){
			$this->template_path = $tpl;
			$this->template->assign(array("template_path"=>$this->template_path));
			$this->template->prefilter = "addImageAttributesBefore | ".$this->template->prefilter." | addImageAttributes ";
		}else{
			$this->template->prefilter = "addImageLazyAttributes | ".$this->template->prefilter;
		}
		$this->print_layout($layoutPath);
		return;
	}

	public function getTab()
	{
		$getParams = $this->input->get();
		$tpl = isset($getParams['no']) ? 'main/' . $getParams['no'] : '';
		$layoutPath = check_display_skin_file($this->skin, $tpl);
		if ($layoutPath === false) {
			show_error(getAlert('et001'));
		}

		if($this->designMode){
			$this->template_path = $tpl;
			$this->template->assign(array("template_path"=>$this->template_path));
			$this->template->prefilter		= "addImageAttributesBefore | ".$this->template->prefilter." | addImageAttributes";
		}
		$this->template->define(array('topbar'=>$layoutPath));
		$html = $this->template->fetch("topbar");
		echo $html;
		return;
	}

	public function getGoodAjax()
	{
		$tpl_path = $this->skin."/_modules/common/getGoodAjax.html";
		$this->template->assign(array('seq'=>$_GET["seq"],'perpage'=>$_GET["perpage"]));
		$this->template->define(array('goods'=>$tpl_path));
		$html = $this->template->fetch("goods");
		echo $html;
		return;
	}
}

