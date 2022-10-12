<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class tooltip extends selleradmin_base {

	public function __construct() {
		parent::__construct();
	}

	// member
	public function member()
	{
		$snsinfo = array();
		$snsinfo['페이스북']= array("email"=>2,"name"=>1,"sex"=>1,"birthday"=>1,"nickname"=>0);
		$snsinfo['트위터'] = array("email"=>0,"name"=>0,"sex"=>0,"birthday"=>0,"nickname"=>0);
		$snsinfo['네이버']	= array("email"=>2,"name"=>2,"sex"=>2,"birthday"=>2,"nickname"=>2);
		$snsinfo['카카오']	= array("email"=>0,"name"=>0,"sex"=>0,"birthday"=>0,"nickname"=>1);
		//$snsinfo['다음']	= array("email"=>0,"name"=>0,"sex"=>0,"birthday"=>0,"nickname"=>1); //#27792 2019-01-18 ycg Daum 연동 서비스 종료
		//$snsinfo['인스타그램']	= array("email"=>0,"name"=>0,"sex"=>0,"birthday"=>0,"nickname"=>1);
		$snsinfo['애플']	= array("email"=>2,"name"=>1,"sex"=>0,"birthday"=>0,"nickname"=>0);

		$this->template->assign(array('snsinfo'=>$snsinfo));

		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//bank
	public function bank()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//cache
	public function cache()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//delivery_company
	public function delivery_company()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//goods
	public function goods()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//manager
	public function manager()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//multi
	public function multi()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//operating
	public function operating()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//order
	public function order()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//pg
	public function pg()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//protect
	public function protect()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//reserve
	public function reserve()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//sale
	public function sale()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//search
	public function search()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//seo
	public function seo()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//shipping_group
	public function shipping_group()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//snsconf
	public function snsconf()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//video
	public function video()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//o2o
	public function o2o()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	//push_history
	public function push_history()
	{
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	public function coupon(){
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	public function promotion_coupon(){
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	public function marketing(){
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	public function mobile_app(){
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	public function design(){
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	public function excel(){
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	public function statistic(){
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}
}

/* End of file main.php */
/* Location: ./app/controllers/admin/tooltip.php */ 
