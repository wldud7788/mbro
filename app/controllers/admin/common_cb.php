<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/common_base".EXT);

class common_cb extends common_base {
	public function admin_goods_image()
	{
		$goods_seq	= $_GET['goods_seq'];
		$idx 		= $_GET['idx'];
		$image_type	= $_GET['image_type'];

		$this->load->model('goodsmodel');
		$images = $this->goodsmodel->get_goods_image($goods_seq);
		$image_src = $images[$idx][$image_type]['image'];
		echo $image_src;
	}
}