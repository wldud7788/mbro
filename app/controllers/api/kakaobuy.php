<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/api_base".EXT);

/**
 * 카카오톡구매 관련 API
 * @api
*/
class kakaobuy extends api_base
{
	function __construct() {
		parent::__construct();
		
		$this->load->helper('order');
		$this->talkbuyCfg = config_load("talkbuy");
	}

	/**
	 * 주문 수집 프로세스
	 */
	function orders_post() {
		writeCsLog($this->input->post(), "orders_request" , "kakaobuy");
		$shopKey = $this->input->post('shopKey');
		
		if(empty($shopKey)) {
			$this->response404();
		}
		if($shopKey != $this->talkbuyCfg['shopKey']) {
			$this->response403();
		}

		$this->load->library('partnerlib');
		$this->load->library('talkbuylibrary');
		$this->load->library('talkbuy_ordersheet_rebuild');

		$content = $this->input->post('content');
		$subType = $this->input->post('subType');

		$content = $this->talkbuy_ordersheet_rebuild->dataRebuild($content);
		// 1. 주문 등록 프로세스 실행
		$save_order_list = array();
		if(!empty($content)) {
			foreach($content as $order) {
				$result = $this->talkbuylibrary->set_talkbuy_order($order);
				if($result) $save_order_list = $result + $save_order_list;
			}
		}

		// 2. 주문상태 체크하여 주문상태에 맞게 업데이트 필요 - 숫자로 변경하여 모든 단계 재검증 할 것!
		foreach($content as $order) {
			if($subType == "STATUS_CHANGE") {
				$result = $this->talkbuylibrary->proc_talkbuy_order($order);
				
			} else if($subType == "DELIVERY_ADDRESS_CHANGE") {
				$result = $this->talkbuylibrary->change_talkbuy_order($order);
				
			}			
			if($result) $save_order_list = $result+ $save_order_list;
		}

		// 4. 변경된 주문 유무에 따라 success 값 분기처리
		if(is_array($save_order_list) && count($save_order_list) > 0) {
			$res = array(
				'success' => true,
				'data' => array(
					'save_order_list'=>$save_order_list,
				)
			);
		} else {
			$res = array(
				'success' => false,
				'data' => array(
					'message'=>"등록 및 변경된 주문건이 없습니다.",
				)
			);
		}
		
		
		$res = array(
			'success' => true,
			'data' => array(
				'save_order_list'=>[],
			)
		);

        return $this->response($res);
	}

	/**
	 * 중계서버에 상품 가격 정보 전달
	 */
	function goods_post() {
		writeCsLog($this->input->post(), "goods_get" , "kakaobuy");
		$shopKey = $this->input->post('shopKey');
		
		if(empty($shopKey)) {
			$this->response404();
		}
		if($shopKey != $this->talkbuyCfg['shopKey']) {
			$this->response403();
		}

		$this->load->library('partnerlib');
		$this->load->library('talkbuylibrary');
		$this->load->library('sale');

		$goods_seqs = $this->input->post('goods_seqs');

		// sale 라이브러리 사용 시 한번만 사용하기 때문에 for 문 밖에 위치함
		$applypage						= 'option';
		$param['cal_type']				= 'list';
		$param['member_seq']			= '0';
		$this->sale->set_init($param);
		$this->sale->preload_set_config($applypage);

		$goods_arr = explode(',',$goods_seqs);
		foreach($goods_arr as $goods_seq) {
			$products[] = $this->talkbuylibrary->set_talkbuy_goods_sale($goods_seq);
		}

		$res = array(
			'success' => true,
			'products'=> $products,
		);
		return $this->response($res);
	}

	/**
	 * 상품 후기 수집 프로세스
	 */
	function reviews_post() {
		writeCsLog($this->input->post(), "reviews_post" , "kakaobuy");
		$shopKey = $this->input->post('shopKey');
		
		if(empty($shopKey)) {
			$this->response404();
		}
		if($shopKey != $this->talkbuyCfg['shopKey']) {
			$this->response403();
		}

		$this->load->library('partnerlib');
		$this->load->library('talkbuylibrary');
		$this->load->library('Board/BoardLibrary',array('boardid'=>'goods_review'));

		$content = $this->input->post('talkbuyResponse');
		$subType = $this->input->post('subType');

		if($subType == "REVIEW_CHANGE") {
			$result = array();
			foreach($content as $data) {
				$review_result = $this->talkbuylibrary->set_talkbuy_review($data);
				$result[$data['reviewId']] = $review_result;
			}
		}

		$res = array(
			'success' => true,
			'data' => $result
		);
		writeCsLog($res, "response" , "kakaobuy");
		return $this->response($res);
	}

	/**
	 * 상품 문의 수집 프로세스
	 */
	function qnas_post() {
		writeCsLog($this->input->post(), "qnas_post" , "kakaobuy");
		$shopKey = $this->input->post('shopKey');
		
		if(empty($shopKey)) {
			$this->response404();
		}
		if($shopKey != $this->talkbuyCfg['shopKey']) {
			$this->response403();
		}

		$this->load->library('partnerlib');
		$this->load->library('talkbuylibrary');
		$this->load->library('Board/BoardLibrary',array('boardid'=>'talkbuy_qna'));

		$content = $this->input->post('talkbuyResponse');
		$subType = $this->input->post('subType');
		if($subType == "QUESTION_CHANGE") {
			$result = array();
			foreach($content as $data) {
				$qna_result = $this->talkbuylibrary->set_talkbuy_qna($data);
				$result[$data['questionId']] = $qna_result;
			}
		}
		
		$res = array(
			'success' => true,
			'data' => $result
		);
		writeCsLog($res, "response" , "kakaobuy");
		return $this->response($res);
	}
}
