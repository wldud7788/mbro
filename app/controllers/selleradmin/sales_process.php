<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class sales_process extends selleradmin_base {

	public function __construct() {
		parent::__construct();
		//세금계산서/현금영수증
		$this->load->model('salesmodel');
		$this->load->library('cashtax');
	}

	/* 현금영수증발급 */
	public function cashreceiptwrite()
	{

		$creceipt_number				= str_replace("-", "", $_POST['creceipt_number'][$_POST['cuse']]);
		$cashparams['typereceipt'	]			= 2;
		$cashparams['type'				]			= 1;//관리자수동
		$cashparams['price'				]			= $_POST['amount'];
		$cashparams['supply'			]			= $_POST['supply'];
		$cashparams['surtax'			]			= $_POST['surtax'];
		$cashparams['person']					= $_POST['name'];
		$cashparams['email']						= $_POST['email'];
		$cashparams['phone']						= $_POST['phone'];
		$cashparams['cuse']						= $_POST['cuse'];
		$cashparams['goodsname'			]	= $_POST['goodsname'];
		$cashparams['creceipt_number'	]	= $creceipt_number;
		$cashparams['regdate']					= date('Y-m-d H:i:s');
		$cashparams['order_seq'		]		= date('YmdHis').$result_id;


		$result_id = $this->salesmodel->sales_write($cashparams);

		$result = firstmall_typereceipt($cashparams['order_seq'], $result_id);
		if($result){
			$callback = "parent.document.location.reload();";
			openDialogAlert("관리자에 의해 현금영수증이 신청되었습니다.",400,140,'parent',$callback);
		}else{
			$callback = "parent.document.location.reload();";
			openDialogAlert("발급오류",400,140,'parent',$callback);
		}

		/*
		$cashparams['paydt']= $cashparams['regdate'];

		$taxResult = $this->cashtax->getCashTax('pay', $cashparams);

		if (is_array($taxResult) == true)
		{
			$taxResult['seq']						= $result_id;
			$taxResult['tstep']					= 2;//발급완료
			$taxResult['issue_date']			= date('Y-m-d H:i:s');
			$taxResult['order_seq']			= $cashparams['order_seq'];
			$this->salesmodel->sales_modify($taxResult);
			$callback = "parent.document.location.reload();";
			openDialogAlert("현금영수증이 발급 되었습니다.",400,140,'parent',$callback);
		}
		else
		{
			$upResult['seq']					= $result_id;
			$upResult['tstep']				= 4;//발급실패
			$upResult['issue_date']		= date('Y-m-d H:i:s');
			$upResult['order_seq']		= $cashparams['order_seq'];
			$this->salesmodel->sales_modify($upResult);

			$this->cashtax->getCashTax('mod', $cashparams);
			$callback = "parent.document.location.reload();";
			openDialogAlert($taxResult,400,140,'parent',$callback);
		}
		*/
	}

	//현금영수증 발급취소
	public function cashreceiptcancel()
	{
		$delidar = @explode(",",$_POST['delidar']);
		$delnum = 0;
		for($i=0;$i<sizeof($delidar);$i++){ if(empty($delidar[$i]))continue;
			$upseq = $delidar[$i];

			$sc['whereis']	= ' and  seq="'.$upseq.'" ';
			$sc['select']		= '  *  ';
			$cashparams 		= $this->salesmodel->get_data($sc);
			if($cashparams){
				$upResult = $this->cashtax->getCashTax('mod', $cashparams);
				if (is_array($upResult) == true)
				{
					$upResult['seq']				= $cashparams['seq'];
					$upResult['issue_date']	= date('Y-m-d H:i:s');
					$upResult['tstep']			= 3;//발급취소
					//debug_var($upResult);
					$result = $this->salesmodel->sales_modify($upResult);

					if($result) {
						$delnum++;
					}
				}else{
					$return = array('result'=>true, 'msg'=>$upResult);
					echo json_encode($return);
					exit;
				}
			}
		}
		$return = array('result'=>true, 'msg'=>"[".$delnum."]건의 현금영수증의 발급이 취소되었습니다.");
		echo json_encode($return);
		exit;
	}


	public function taxwrite()
	{
		$cashparams['typereceipt'		]			= 1;
		$cashparams['type'				]			= 1;//관리자수동
		$cashparams['price'				]			= $_POST['amount'];
		$cashparams['supply'			]			= $_POST['supply'];
		$cashparams['surtax'			]			= $_POST['surtax'];
		$cashparams['person']						= $_POST['person'];
		$cashparams['email']						= $_POST['email'];
		$cashparams['phone']						= $_POST['phone'];
		$cashparams['busi_no']						= $_POST['busi_no'];
		$cashparams['co_name']						= $_POST['co_name'];
		$cashparams['co_ceo']						= $_POST['co_ceo'];
		$cashparams['co_status']					= $_POST['co_status'];
		$cashparams['co_type']						= $_POST['co_type'];
		$cashparams['zipcode']						= implode("-",$_POST['zipcode']);
		$cashparams['address']						= ($_POST['address_type'])?$_POST['address_type']:'zibun';
		$cashparams['address']						= $_POST['address'];
		$cashparams['address_street']			= $_POST['address_street'];
		$cashparams['address_detail']			= $_POST['address_detail'];
		//$cashparams['order_seq']					= $_POST['order_seq'];
		$cashparams['regdate']						= date('Y-m-d H:i:s');

		$arrBasic = ($this->config_basic)?$this->config_basic:config_load('basic');

		if(!preg_match("/(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)/i", $_POST['email'], $regs)){
			openDialogAlert("이메일 형식이 올바르지 않습니다.",400,140,'parent',"");
			exit;
		}

		if($arrBasic["businessConditions"] == "" || $arrBasic["businessLine"] == ""){
			openDialogAlert("공급자 사업자 정보에 업태/종목이 작성되어 있지 않습니다.",400,140,'parent',"");
			exit;
		}

		$result_id = $this->salesmodel->sales_write($cashparams);

		$cashparams['order_seq'		]		= date('YmdHis').$result_id;
		$cashparams['paydt']				= $cashparams['regdate'];

		$taxResult = $this->cashtax->getCashTax('pay', $cashparams);

		if (is_array($taxResult) == true)
		{
			$taxResult['seq']						= $result_id;
			$taxResult['tstep']					= 2;//발급완료
			$taxResult['issue_date']			= date('Y-m-d H:i:s');
			$taxResult['order_seq']			= $cashparams['order_seq'];
			$this->salesmodel->sales_modify($taxResult);
			$callback = "parent.document.location.reload();";
			openDialogAlert("관리자에 의해 세금계산서가 신청되었습니다.",400,140,'parent',$callback);
		}
		else
		{
			$upResult['seq']					= $result_id;
			$upResult['tstep']				= 4;//발급실패
			$upResult['issue_date']		= date('Y-m-d H:i:s');
			$upResult['order_seq']		= $cashparams['order_seq'];
			$this->salesmodel->sales_modify($upResult);

			$this->cashtax->getCashTax('mod', $cashparams);
			$callback = "parent.document.location.reload();";
			openDialogAlert($taxResult,400,140,'parent',$callback);
		}
	}



	//세금계산서 발급완료처리
	public function taxupdate()
	{
		$delidar = @explode(",",$_POST['delidar']);
		$delnum = 0;
		for($i=0;$i<sizeof($delidar);$i++){ if(empty($delidar[$i]))continue;

			$upResult['seq']				= $delidar[$i];
			$upResult['tstep']			= 2;//발급완료
			$upResult['pg_kind']		= $this->config_system['pgCompany'];
			$result = $this->salesmodel->sales_modify($upResult);
			if($result) {
				$delnum++;
			}
		}
		$return = array('result'=>true, 'msg'=>"[".$delnum."]건의 세금계산서가 발급완료되었습니다.");
		echo json_encode($return);
		exit;
	}


	public function tax_update()
	{
		$seq			= ($_POST["seq"])?$_POST["seq"]:$_GET["seq"];
		$order_seq		= ($_POST["order_seq"])?$_POST["order_seq"]:$_GET["order_seq"];

		$orders = config_load('order');
		$this->template->assign('orders',$orders);
		$arrBasic = ($this->config_basic)?$this->config_basic:config_load('basic');
		if($arrBasic["businessConditions"] == "" || $arrBasic["businessLine"] == ""){

			$return = array('result'=>false, 'msg'=>"공급자 사업자 정보에 업태/종목이 작성되어 있지 않습니다.");
			echo json_encode($return);
			exit;
		}

		if($orders['biztype']=='tax' && $orders['hiworks_use']=='Y'){
			if($this->config_system['webmail_admin_id'] && $this->config_system['webmail_domain'] && $this->config_system['webmail_key']){
				$sql	= "SELECT * FROM fm_sales WHERE seq = '{$seq}'";
				$query = $this->db->query($sql);
				$data = $query->result_array();

				if(!$data[0]['email'] && $data[0]['order_seq']){
					$sql	= "SELECT * FROM fm_order WHERE order_seq = '{$data[0]['order_seq']}'";
					$query = $this->db->query($sql);
					$order_data = $query->result_array();
					$data[0]['email'] = $order_data[0]['order_email'];
				}

				$result = $this->salesmodel->hiworks_bill_send($data[0]);
				if($result['result']){
					$return = array('result'=>true, 'msg'=>"처리 되었습니다.");
					echo json_encode($return);
					exit;
				}else{
					$return = array('result'=>false, 'msg'=>$result['message']);
					echo json_encode($return);
					exit;
				}
			}else{
				$return = array('result'=>false, 'msg'=>"하이웍스 정보가 올바르지 않습니다.\n설정> 매출증빙에서 하이웍스를 설정해 주세요.");
				echo json_encode($return);
				exit;
			}

		}else{
			$upResult['seq']			= $seq;
			$upResult['tstep']			= 2;//발급완료
			$upResult['pg_kind']		= $this->config_system['pgCompany'];
			$result = $this->salesmodel->sales_modify($upResult);

			$return = array('result'=>true, 'msg'=>"처리되었습니다.");
			echo json_encode($return);
			exit;
		}
	}

	//신청서삭제
	public function sales_multi_delete()
	{
		$delidar = @explode(",",$_POST['delidar']);
		$delnum = 0;
		for($i=0;$i<sizeof($delidar);$i++){ if(empty($delidar[$i]))continue;
			$delseq = $delidar[$i];
			$result = $this->salesmodel->sales_delete($delseq);
			if($result) {
				if($_POST['type'] != 1) {//수동발급이 아닌경우
					$this->db->where('order_seq',$_POST['order_seq']);
					$this->db->update('fm_order',array('typereceipt'=>'0'));
				}
				$delnum++;
			}
		}

		$return = array('result'=>true, 'msg'=>"[".$delnum."]건의 신청서가 삭제되었습니다.");
		echo json_encode($return);
		exit;
	}


	### 수기등록
	public function manual_cash(){
		$seq = $_POST['seq'];
		$sql = "UPDATE fm_sales SET tstep = 2 WHERE seq = '{$seq}'";
		$result = $this->db->query($sql);
		echo json_encode($result);
		exit;
	}
}

/* End of file sales_process.php */
/* Location: ./app/controllers/selleradmin/sales_process.php */