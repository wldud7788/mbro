<?php
class Accountmodel extends CI_Model {

	var $_arr_shipping_type = '';

	function __construct() {
		parent::__construct();
		
		//정산가능 배송타입 선언
		$this->_arr_shipping_type = array('delivery','direct_delivery','quick','freight','custom');
	}

	public function get_refund_data($export, $provider){
		$sql = "
		SELECT
			sum(A.refund_price) as r_price,
			sum(B.ea) as r_ea
		FROM
			fm_order_refund A
			left join fm_order_refund_item B ON A.refund_code = B.refund_code
			left join fm_order_item C ON C.item_seq = B.item_seq
		WHERE
			A.status = 'complete'
			AND A.refund_date like '{$export}%'
			AND C.provider_seq = '{$provider}'
			";
		//echo $sql."<br>";
		$query = $this->db->query($sql);
		$data = $query->result_array();

		$temp = array($data[0]['r_ea'], $data[0]['r_price']);
		return $temp;
	}

	public function get_charge_data($price, $provider){
		$sql = "SELECT * FROM fm_provider_charge WHERE link = '1' AND provider_seq = '{$provider}'";
		$query = $this->db->query($sql);
		$data = $query->result_array();

		$calcu = ($price * ($data[0]['charge']/100));

		if($price<=0){
			$temp = array(0, 0);
		}else{
			$temp = array($calcu, $data[0]['charge']);
		}

		return $temp;
	}

	public function set_return($return_code,$return_date)
	{
		$day = substr($return_date,8,2);
		if($day <= 15) $account_2round = 1;
		else $account_2round = 2;
		if($day <= 7) $account_4round = 1;
		else if($day <= 14) $account_4round = 2;
		else if($day <= 21) $account_4round = 3;
		else $account_4round = 4;

		$query = "select provider_seq from fm_order_shipping where shipping_seq=(select shipping_seq from fm_order_item where item_seq=(select item_seq from fm_order_return_item where return_code=? limit 1))";
		$query = $this->db->query($query,array($return_code));
		$row = $query->row_array();
		$shipping_provider_seq = $row['provider_seq'];

		$bind = array();
		$bind[] = $shipping_provider_seq;
		$bind[] = $account_2round;
		$bind[] = $account_4round;
		$bind[] = $return_code;
		$query = "update fm_order_return set
						shipping_provider_seq=?,account_2round=?,account_4round=?
					where return_code=?";
		$this->db->query($query,$bind);
	}

	public function set_refund($refund_code,$refund_date)
	{
		$day = substr($refund_date,8,2);
		if($day <= 15) $account_2round = 1;
		else $account_2round = 2;
		if($day <= 7) $account_4round = 1;
		else if($day <= 14) $account_4round = 2;
		else if($day <= 21) $account_4round = 3;
		else $account_4round = 4;

		$query = "select provider_seq from fm_order_item where item_seq=(select item_seq from fm_order_refund_item where refund_code=? limit 1)";
		$query = $this->db->query($query,array($refund_code));
		$row = $query->row_array();
		$provider_seq = $row['provider_seq'];

		$bind = array();
		$bind[] = $provider_seq;
		$bind[] = $account_2round;
		$bind[] = $account_4round;
		$bind[] = $refund_code;
		$query = "update fm_order_refund set
						shipping_provider_seq=?,account_2round=?,account_4round=?
					where refund_code=?";
		$this->db->query($query,$bind);
	}

	public function set_account_round($data_export,$data_export_item,$shipping_date=''){

		if(!$shipping_date) $shipping_date = date("Y-m-d");
		$day = substr($shipping_date,8,2);
		if($day <= 15)	$account_2round = 1;
		else $account_2round = 2;
		if($day <= 7)	$account_4round = 1;
		else if($day <= 14) $account_4round = 2;
		else if($day <= 21) $account_4round = 3;
		else $account_4round = 4;
		$provider_seq = $data_export_item[0]['provider_seq'];

		$bind = array();
		$bind[] = $account_2round;
		$bind[] = $account_4round;
		$bind[] = $data_export['export_code'];
		$query = "update fm_goods_export set
						account_2round=?,account_4round=?
					where export_code=?";
		$this->db->query($query,$bind);

		$bind = array();
		$bind[] = $account_2round;
		$bind[] = $account_4round;
		$bind[] = $data_export['order_seq'];
		$bind[] = $provider_seq;
		$query = "update fm_order_shipping set account_2round=?,account_4round=?
					where order_seq=? and provider_seq=?";
		$this->db->query($query,$bind);

		if($data_export_item) foreach($data_export_item as $item) $r_item_seq[] = $item['item_seq'];
		if($r_item_seq){
			$r_item_seq = array_unique($r_item_seq);

			$bind = array();
			$bind[] = $account_2round;
			$bind[] = $account_4round;
			foreach($r_item_seq as $item_seq){
				$bind[3] = $item_seq;
				$query = "update fm_order_item set account_2round=?,account_4round=?
							where item_seq=?";
				$this->db->query($query,$bind);
			}
		}

	}

	// 정산 데이터 추출
	public function get_account_data($acc_seq){
		$sql	= "select * from fm_account where seq = '".$acc_seq."' ";
		$query	= $this->db->query($sql);
		$result	= $query->row_array();

		return $result;
	}

	// 정산 완료처리
	public function account_complete_item($param){
		$account_round			= $param['account_round'];
		$round_field			= $param['round_field'];
		$account_status			= $param['account_status'];
		$account_date			= $param['account_date'];
		$provider_seq			= $param['provider_seq'];
		$updata['account_date']	= $account_date.'-01 00:00:00';
		$updata['account_seq']	= $param['account_seq'];


		// 주문상품 정산완료 처리
		$sql ="SELECT
			oitem.item_seq
			FROM fm_goods_export_item item
			LEFT JOIN fm_order_item_option opt ON opt.item_option_seq = item.option_seq and item.option_seq
			LEFT JOIN fm_order_item_suboption sub ON sub.item_suboption_seq = item.suboption_seq and item.suboption_seq
			LEFT JOIN fm_goods_export exp ON exp.export_code=item.export_code
			LEFT JOIN fm_order ord ON ord.order_seq=exp.order_seq
			LEFT JOIN fm_order_item oitem ON oitem.item_seq=item.item_seq
			WHERE
				exp.status = '75'
				and (ord.linkage_id is null or ord.linkage_id != 'connector')
				and substring( shipping_date, 1, 7 )=?
				and oitem.provider_seq=?";
		if($round_field){
			$sql .= " and oitem.".$round_field."='".$account_round."'";
		}
		$sql .= " GROUP BY oitem.item_seq";
		$query = $this->db->query($sql,array($account_date,$provider_seq));

		foreach($query->result_array() as $v){
			$this->db->where('item_seq', $v['item_seq']);
			$this->db->where('account_seq is null', null, false);
			$result = $this->db->update('fm_order_item', $updata);

		}
	}

	public function migration(){
		$query = "select * from fm_account";
		$query = $this->db->query($query);
		foreach($query->result_array() as $data_acc){

			if($data_acc['period_type']==2) $param['round_field']	= "account_2round";
			else if($data_acc['period_type']==4) $param['round_field']	= "account_4round";
			else unset($param['round_field']);

			$param['account_round'] = $data_acc['account_round'];
			$param['account_status'] = $data_acc['acc_status'];
			$param['account_date'] = $data_acc['acc_date'];
			$param['provider_seq'] = $data_acc['provider_seq'];
			$param['account_seq'] = $data_acc['seq'];

			$this->account_complete_item($param);
			$this->set_export_accountstatus($param);

			$this->accountmodel->account_return($data_acc['period_type'],$data_acc['account_round'],$data_acc['acc_date'],$data_acc['provider_seq'],$data_acc['seq']);
			$this->accountmodel->account_refund($data_acc['period_type'],$data_acc['account_round'],$data_acc['acc_date'],$data_acc['provider_seq'],$data_acc['seq']);
			$this->accountmodel->account_order_shipping($data_acc['period_type'],$data_acc['account_round'],$data_acc['acc_date'],$data_acc['provider_seq'],$data_acc['seq']);
		}
	}

	// 출고 정산상태 변경
	public function update_export_account_status($account_seq,$account_status)
	{
		$bind = array($account_status,$account_seq);
		$query = "update fm_goods_export set account_gb=? where account_seq=?";
		$this->db->query($query,$bind);
	}

	// 출고정보 정산 처리
	public function set_export_accountstatus($param){
		$account_round			= $param['account_round'];
		$round_field			= $param['round_field'];
		$account_status			= $param['account_status'];
		$account_date			= $param['account_date'];
		$provider_seq			= $param['provider_seq'];

		$updata['account_date']	= $account_date.'-01 00:00:00';
		$updata['account_gb']	= $account_status;
		$updata['account_seq']	= $param['account_seq'];

		$bind[0] = $updata['account_date'];
		$bind[1] = $updata['account_gb'];
		$bind[2] = $updata['account_seq'];

		$sql ="SELECT
			exp.export_seq
			FROM fm_goods_export_item item
			LEFT JOIN fm_order_item_option opt ON opt.item_option_seq = item.option_seq and item.option_seq
			LEFT JOIN fm_order_item_suboption sub ON sub.item_suboption_seq = item.suboption_seq and item.suboption_seq
			LEFT JOIN fm_goods_export exp ON exp.export_code=item.export_code
			LEFT JOIN fm_order ord ON ord.order_seq=exp.order_seq
			LEFT JOIN fm_order_item oitem ON oitem.item_seq=item.item_seq
			WHERE
				exp.status = '75'
				and substring( shipping_date, 1, 7 )=?
				and oitem.provider_seq=?";
		if($round_field){
			$sql .= " and exp.".$round_field."='".$account_round."'";
		}
		$sql .= " GROUP BY exp.export_seq";
		$query = $this->db->query($sql,array($account_date,$provider_seq));

		foreach($query->result_array() as $v){
			$bind[3] = $v['export_seq'];
			//$query = "update fm_goods_export set account_date=?,account_gb=?,account_seq=? where export_seq=? and account_seq is null";
			$query = "update fm_goods_export set account_date=?,account_gb=?,account_seq=? where export_seq=? and (account_seq is null or account_seq = 0)"; //2018-04-02 오류후 다시 시도시 
			$this->db->query($query,$bind);
		}
	}

	// 반품
	public function account_refund_query($round_field,$account_round,$account_date,$provider_seq,$account_seq='',$field_query='',$migrationCheckDate=''){		
		
		$arr_date = $this->period2date($round_field,$account_round,$account_date);
		$arr_datetime[0] = $arr_date[0]." 00:00:00";
		$arr_datetime[1] = $arr_date[1]." 23:59:59";
		
		$bind = array($arr_datetime[0],$arr_datetime[1]);
		if( $provider_seq ){
			$where_arr[] = "C.provider_seq = ?";
			$bind[] = $provider_seq;
		}		
		if( !$field_query ){
			$field_query = "A.refund_seq";
		}
		if( $account_seq ){
			$where_arr[] = "A.account_seq = ?";
			$bind[] = $account_seq;
		}else{
			$where_arr[] = "A.account_seq is null";
		}
		// 구정산 노출 기준 : 신정산 마이그레이션 날짜 이전 주문(결제)건만 노출.  @20190514 pjm
		if($migrationCheckDate){
			$where_arr[] = " ord.deposit_date < '".$migrationCheckDate."'";
		}

		if( $where_arr ){
			$where_str = " AND ".implode(' AND ',$where_arr);
		}
		$query = "
			SELECT
				".$field_query."
			FROM
				fm_order_refund A
				LEFT JOIN fm_order_refund_item B ON A.refund_code = B.refund_code
				LEFT JOIN fm_order_item_option opt ON opt.item_option_seq = B.option_seq and B.option_seq and (B.suboption_seq is null or B.suboption_seq ='')
				LEFT JOIN fm_order_item_suboption sub ON sub.item_suboption_seq = B.suboption_seq and B.suboption_seq
				,fm_order_item C
				,fm_order ord
			WHERE
				A.refund_type in ('return','shipping_price')
				AND A.status = 'complete'
				AND C.item_seq = B.item_seq
				AND ord.order_seq=A.order_seq
				AND A.refund_date between ? and ?
				".$where_str;
		$query = $this->db->query($query,$bind);
		return $query;
	}

	public function account_refund($round_field,$account_round,$account_date,$provider_seq,$account_seq){
		$query = $this->account_refund_query($round_field,$account_round,$account_date,$provider_seq);
		foreach($query->result_array() as $data){
			$query = "update fm_order_refund set account_seq=? where refund_seq=? and account_seq is null";
			$this->db->query($query,array($account_seq,$data['refund_seq']));
		}
	}

	public function account_return_detail_query($round_field,$account_round,$account_date,$provider_seq,$migrationCheckDate=''){
		

		// 구정산 노출 기준 : 신정산 마이그레이션 날짜 이전 주문(결제)건만 노출.  @20190514 pjm
		if($migrationCheckDate){
			$first_where = " and ord.deposit_date < '".$migrationCheckDate."'";
		}

		$arr_date = $this->period2date($round_field,$account_round,$account_date);
		$arr_datetime[0] = $arr_date[0]." 00:00:00";
		$arr_datetime[1] = $arr_date[1]." 23:59:59";

		$bind = array($arr_datetime[0],$arr_datetime[1],$provider_seq);

		$query = "
		select
			tb.*,
			tb.return_shipping_price as t_shipping,
			(SELECT concat(order_user_name,'|',m.member_seq,'|',m.userid,'|',m.rute,'|',(SELECT group_name FROM fm_member_group where group_seq=m.group_seq)) FROM fm_member m,fm_order ord WHERE m.member_seq=ord.member_seq and ord.order_seq=tb.order_seq) memberinfo
		from (
			select t1.*, t2.shipping_provider_seq as t_shipping_provider_seq,
					opt.option1,opt.option2,opt.option3,opt.option4,opt.option5,
					sub.suboption,t2.goods_name
			from
				fm_order_return t1,
				(
					select
						a.return_code, e.shipping_provider_seq,
						b.item_seq, b.option_seq, b.suboption_seq,
						c.goods_name
					from
						fm_order_return a,
						fm_order_return_item b,
						fm_order_item c,
						fm_order as ord,
						fm_goods_export_item d,
						fm_goods_export e						
					where
						a.return_code=b.return_code
						and b.item_seq = c.item_seq
						and b.option_seq = d.option_seq
						and d.export_code=e.export_code
						and a.return_date between ? and ?
						and c.provider_seq=?
						and ord.order_seq=c.order_seq
						and a.return_shipping_price > 0
						and a.`status`='complete'
						".$first_where."
				) t2
				LEFT JOIN fm_order_item_option opt ON opt.item_option_seq = t2.option_seq and t2.option_seq and (t2.suboption_seq is null or t2.suboption_seq ='')
				LEFT JOIN fm_order_item_suboption sub ON sub.item_suboption_seq = t2.suboption_seq and t2.suboption_seq
			where
				t1.return_code=t2.return_code
			group by t1.return_code
		) tb
		";

		$query = $this->db->query($query,$bind);
		return $query;
	}

	//
	public function account_return_query($round_field,$account_round,$account_date,$provider_seq){
		$arr_date = $this->period2date($round_field,$account_round,$account_date);
		$arr_datetime[0] = $arr_date[0]." 00:00:00";
		$arr_datetime[1] = $arr_date[1]." 23:59:59";

		$bind = array($arr_datetime[0],$arr_datetime[1],$provider_seq);

		$query = "
		select
			sum(tb.return_shipping_price) as return_shipping_price, tb.shipping_provider_seq
		from (
			select t1.return_code,t2.shipping_provider_seq,t1.return_shipping_price
			from
				fm_order_return t1,
				(
					select
						a.return_code, e.shipping_provider_seq
					from
						fm_order_return a,
						fm_order_return_item b,
						fm_order_item c,
						fm_goods_export_item d,
						fm_goods_export e
					where
						a.return_code=b.return_code
						and b.item_seq = c.item_seq
						and b.option_seq = d.option_seq
						and d.export_code=e.export_code
						and a.return_date between ? and ?
						and c.provider_seq=?
						and a.return_shipping_price > 0
						and a.`status`='complete'
				) t2
			where
				t1.return_code=t2.return_code
			group by t1.return_code
		) tb group by tb.shipping_provider_seq
		";
		$query = $this->db->query($query,$bind);
		return $query;
	}

	public function account_return($round_field,$account_round,$account_date,$provider_seq,$account_seq)
	{
		$arr_date = $this->period2date($round_field,$account_round,$account_date);
		$arr_datetime[0] = $arr_date[0]." 00:00:00";
		$arr_datetime[1] = $arr_date[1]." 23:59:59";
		$bind = array($arr_datetime[0],$arr_datetime[1],$provider_seq);

		$query = "
		select
			a.return_seq
		from
			fm_order_return a,
			fm_order_return_item b,
			fm_order_item c
		where
			a.return_code=b.return_code
			and b.item_seq=c.item_seq
			and a.return_shipping_price > 0
			and a.return_date between ? and ?
			and c.provider_seq=?
			and a.`status`='complete'
			and a.account_seq is null";
		$query = $this->db->query($query,$bind);

		foreach($query->result_array() as $data){
			$query = "update fm_order_return set account_seq=? where return_seq=? and account_seq is null";
			$this->db->query($query,array($account_seq,$data['return_seq']));
		}
	}

	public function account_order_shipping_query($round_field,$account_round,$account_date,$provider_seq,$migrationCheckDate)
	{
		$arr_date = $this->period2date($round_field,$account_round,$account_date);
		$bind = array($arr_date[0],$arr_date[1],$provider_seq);

		if($migrationCheckDate){
			$wheres = " and ord.deposit_date < '".$migrationCheckDate."'";
		}

		$query_shipping = "
								select
										sum(delivery_cost) as delivery_cost,
										sum(add_delivery_cost) as add_delivery_cost,
										sum(shipping_cost) as shipping_cost,
										sum(shipping_coupon_sale) as shipping_coupon_sale,
										sum(salescost_provider_coupon) as salescost_provider_coupon,
										sum(shipping_promotion_code_sale) as shipping_promotion_code_sale,
										sum(salescost_provider_promotion) as salescost_provider_promotion,
										provider_seq,
										shipping_method
									from (
										select
											ifnull(os.delivery_cost,0) as delivery_cost,
											ifnull(os.add_delivery_cost,0) as add_delivery_cost,
											ifnull(os.shipping_cost,0) as shipping_cost,
											ifnull(os.shipping_coupon_sale,0) as shipping_coupon_sale,
											ifnull(os.salescost_provider_coupon,0)	as salescost_provider_coupon,
											ifnull(os.shipping_promotion_code_sale,0) as shipping_promotion_code_sale,
											ifnull(os.salescost_provider_promotion,0) as salescost_provider_promotion,
											os.provider_seq,
											os.shipping_method
										from
											fm_order_shipping os
											,fm_order_item_option opt
											,fm_order_item item
											,fm_order ord
											,fm_goods_export_item expi
											,fm_goods_export exp
										where
											os.shipping_seq = opt.shipping_seq
											and expi.option_seq=opt.item_option_seq
											and opt.item_seq=item.item_seq
											and ord.order_seq=item.order_seq
											and exp.export_code=expi.export_code
											and exp.status = '75'
											and exp.shipping_date between ? and ?
											and item.provider_seq=?
											and os.shipping_method in ('".implode("','",$this->_arr_shipping_type)."')
											and os.shipping_type = 'prepay'
											".$wheres."
										group by os.shipping_seq
									) t group by shipping_method";
		$query_shipping = $this->db->query($query_shipping,$bind);
		return $query_shipping;
	}

	public function account_shipping_query_for_shipping_seq($shipping_seq,$field_query,$option_seq,$export_seq='')
	{
		$bind[] = $shipping_seq;
		$bind[] = $option_seq;

		$query_shipping = "
							select
								os.*
							from
								fm_order_shipping os
								,fm_order_item_option opt
								,fm_goods_export_item expi
								,fm_goods_export exp
							where
								os.shipping_seq = opt.shipping_seq
								and expi.option_seq=opt.item_option_seq
								and exp.export_code=expi.export_code
								and os.shipping_seq=?
								and exp.status = '75'
								and opt.item_option_seq=?
								and os.shipping_method in ('".implode("','",$this->_arr_shipping_type)."')
								and exp.export_seq = '".$export_seq."'
								and exp.export_seq = (select exp2.export_seq from fm_goods_export_item expi2,fm_order_item_option opt2,fm_goods_export exp2 where expi2.option_seq=opt2.item_option_seq and expi2.option_seq=opt2.item_option_seq and expi2.export_code=exp2.export_code and opt2.shipping_seq=os.shipping_seq and exp2.status='75' order by exp2.shipping_date,exp2.export_seq limit 1)
							group by os.shipping_seq
						";

		$query_shipping = $this->db->query($query_shipping,$bind);
		return $query_shipping;
	}

	public function account_order_shipping($round_field,$account_round,$account_date,$provider_seq,$account_seq)
	{
		$arr_date = $this->period2date($round_field,$account_round,$account_date);
		$bind = array($arr_date[0],$arr_date[1],$provider_seq);

		$query = "select
						os.shipping_seq
					from
						fm_goods_export exp,fm_goods_export_item expi,fm_order_item_option opt,fm_order_item item,fm_order_shipping os
					where
						exp.export_code=expi.export_code
						and expi.option_seq=opt.item_option_seq
						and opt.shipping_seq = os.shipping_seq
						and opt.item_seq=item.item_seq
						and exp.status = '75'
						and exp.shipping_date between ? and ?
						and item.provider_seq=?
						and os.shipping_method in ('".implode("','",$this->_arr_shipping_type)."')
					";
		$query = $this->db->query($query,$bind);

		foreach($query->result_array() as $data){
			$query = "update fm_order_shipping set account_seq=? where shipping_seq=? and account_seq is null";
			$this->db->query($query,array($account_seq,$data['shipping_seq']));
		}
	}

	## 정산상세, 엑셀다운로드
	public function detail($sc=null){

		$accountAllMiDate				= config_load("accountall_setting");
		if($accountAllMiDate['accountall_migration_date']){
			$accountAllMigrationDate	= explode("-",$accountAllMiDate['accountall_migration_date']);
			$accountAllMigrationTime	= mktime(0,0,0,$accountAllMigrationDate[1],$accountAllMigrationDate[2],$accountAllMigrationDate[0]);
			$migrationCheckDate			= date("Y-m-01 00:00:00", strtotime("+1 month",$accountAllMigrationTime));
		}

		$where = array();

		// 구정산 노출 기준 : 신정산 마이그레이션 날짜 이전 주문(결제)건만 노출.  @20190514 pjm
		if($migrationCheckDate){
			$where[] = "ord.deposit_date < '".$migrationCheckDate."'";
		}
		if($sc['pay_period'] == '2'){
			$account_round = "account_2round";
			$where[] = "exp.".$account_round."='{$sc['account_round']}'";
		}else if($sc['pay_period'] == '4'){
			$account_round = "account_4round";
			$where[] = "exp.".$account_round."='{$sc['account_round']}'";
		}
		if( $sc['account_seq'] != '' ){
			$where[] = "exp.account_seq='{$sc['account_seq']}'";
		}else{
			$where[] = " (exp.account_seq is null or exp.account_seq ='' )";
		}

		$sql = "
			SELECT
				exp.*,
				substring( shipping_date, 1, 7 ) export,
				opt.option1,opt.option2,opt.option3,opt.option4,opt.option5,
				sub.suboption,
				oitem.goods_seq,

				IFNULL(opt.ori_price,0) * IFNULL(item.ea,0) opt_price,
				IFNULL(sub.price,0) * IFNULL(item.ea,0) sub_price,

				(ifnull(cast(opt.commission_price as signed)*cast(item.ea as signed),0) + ifnull(cast(sub.commission_price as signed)*cast(item.ea as signed),0)) as commission_price,

				(opt.member_sale*ifnull(item.ea,0))			as member_sale,
				opt.coupon_sale			as coupon_sale,
				opt.promotion_code_sale	as promotion_code_sale,
				opt.fblike_sale			as fblike_sale,
				opt.mobile_sale			as mobile_sale,
				opt.referer_sale		as referer_sale,
				opt.shipping_seq,
				opt.item_option_seq,

				(IFNULL(opt.salescost_provider_coupon,0) * IFNULL(item.ea,0))	as salescost_provider_coupon,
				(IFNULL(opt.salescost_provider_promotion,0) * IFNULL(item.ea,0))	as salescost_provider_promotion,
				(IFNULL(opt.salescost_provider_referer,0) * IFNULL(item.ea,0))	as salescost_provider_referer,

				opt.promotion_code_sale wcode,
				ifnull(item.ea,0) ea,
				oitem.provider_seq,
				exp.shipping_provider_seq,

				(IFNULL(opt.unit_emoney,0)*IFNULL(item.ea,0) + IFNULL(sub.unit_emoney,0)*IFNULL(item.ea,0)) as emoney,
				(IFNULL(opt.unit_cash,0)*IFNULL(item.ea,0) + IFNULL(sub.unit_cash,0)*IFNULL(item.ea,0)) as cash,
				(IFNULL(opt.unit_enuri,0)*IFNULL(item.ea,0) + IFNULL(sub.unit_enuri,0)*IFNULL(item.ea,0)) as enuri,
				ord.order_user_name,
				ord.payment,
				ord.step,
				ord.member_seq,

				(SELECT userid FROM fm_member WHERE member_seq=ord.member_seq) userid,
				(SELECT rute FROM fm_member WHERE member_seq=ord.member_seq) mbinfo_rute,
				(SELECT group_name FROM fm_member m,fm_member_group g WHERE m.group_seq=g.group_seq and m.member_seq=ord.member_seq) group_name,
				(select goods_name from fm_order_item where item_seq = item.item_seq) goods_name,
				ord.admin_order,
				ord.sns_rute
			FROM
				fm_goods_export_item item
				LEFT JOIN fm_order_item_option opt ON opt.item_option_seq = item.option_seq
				LEFT JOIN fm_order_item_suboption sub ON sub.item_suboption_seq = item.suboption_seq
				LEFT JOIN fm_goods_export exp ON exp.export_code=item.export_code
				LEFT JOIN fm_order ord ON ord.order_seq=exp.order_seq
				LEFT JOIN fm_order_item oitem ON oitem.item_seq=item.item_seq
			WHERE
				exp.status = '75'
				and (ord.linkage_id is null or ord.linkage_id != 'connector')
				and ord.orign_order_seq is null
				AND substring(exp.shipping_date,1,7)='".$sc['export']."'
				AND oitem.provider_seq=?";

		if($where){
			$sql .= ' AND '. implode(' AND ',$where);
		}
		$sql .= " ORDER BY exp.export_seq desc";

		$bind[] = $sc['provider'];
		$query = $this->db->query($sql,$bind);
		foreach($query->result_array() as $v){
			// 배송비
			$v['shipping_cost'] = 0;
			$v['goods_shipping_cost'] = 0;
			if($v['shipping_seq']){
				$field_query = "shipping_method, delivery_cost, add_delivery_cost, shipping_cost, shipping_coupon_sale, salescost_provider_coupon";
				$query_shipping = $this->account_shipping_query_for_shipping_seq($v['shipping_seq'],$field_query,$v['item_option_seq'],$v['export_seq']);
				$data_shipping = $query_shipping -> row_array();

				if( ! $r_ex_shipping[ $v['shipping_seq'] ] ){
					if( $data_shipping['shipping_method'] == 'each_delivery' ){
						$v['goods_shipping_cost'] = (int) $data_shipping['delivery_cost'] + (int) $data_shipping['add_delivery_cost'];
						$r_ex_shipping[ $v['shipping_seq'] ] = 1;
					}else if(in_array($data_shipping['shipping_method'], $this->_arr_shipping_type)){
						$v['shipping_cost']					= (int) $data_shipping['shipping_cost'];
						$v['coupon_sale']					+= $data_shipping['shipping_coupon_sale'];
						$v['shipping_provider_coupon']		= $data_shipping['salescost_provider_coupon'];
						$v['salescost_provider_coupon']		+= $data_shipping['salescost_provider_coupon'];
						$v['promotion_code_sale']			+= $data_shipping['shipping_promotion_code_sale'];
						$v['shipping_provider_promotion']	= $data_shipping['salescost_provider_promotion'];
						$v['salescost_provider_promotion']	+= $data_shipping['salescost_provider_promotion'];
						$r_ex_shipping[ $v['shipping_seq'] ] = 1;
					}
				}
			}

			$data_acc['shipping_cost_by_shop'] = 0;
			if( $v['shipping_provider_seq'] != $v['provider_seq'] ){
				$v['shipping_cost_by_shop']	= (int) $v['shipping_cost'] + (int) $v['goods_shipping_cost'];
			}

					## 할인부담금 관련 추가
			$v['tot_salescost']			= (int) $v['coupon_sale'] + (int) $v['member_sale']
											+ (int) $v['fblike_sale'] + (int) $v['mobile_sale']
											+ (int) $v['promotion_code_sale']
											+ (int) $v['referer_sale']
											+ (int) $v['enuri'];
			$v['tot_salescost_provider']	= $v['salescost_provider_coupon']
											+ $v['salescost_provider_promotion']
											+ $v['salescost_provider_referer'];
			$v['tot_salescost_admin']		= $v['tot_salescost']
											- $v['tot_salescost_provider'];

			$v['admin_coupon_sale']		= $v['coupon_sale'] - $v['salescost_provider_coupon'];
			$v['admin_promotion_sale']	= $v['promotion_code_sale'] - $v['salescost_provider_promotion'];
			$v['admin_referer_sale']	= $v['referer_sale'] - $v['salescost_provider_referer'];

			$v['wmoney']				= $v['emoney'] + $v['cash'];
			$v['price']					= (int) $v['opt_price'] + (int) $v['sub_price'];
			$tt							+= $v['price'];

			$v['mstep']					= $this->arr_step[$v['status']];
			$v['mpayment']				= $this->arr_payment[$v['payment']];

			$v['fee']					= $v['price'] - $v['commission_price'] - $v['tot_salescost_provider'] + $v['shipping_provider_coupon'] + $v['shipping_provider_promotion'];

			$v['fee_percent']			= $v['fee'] / $v['price'] * 100;
			$v['wmoney']				= $v['cash'] + $v['emoney']; // wmoney
			$v['account_price']			= $v['price'] - $v['fee'] + $v['goods_shipping_cost'] + $v['shipping_cost'] - $v['tot_salescost_provider']-$v['shipping_cost_by_shop'];
			$v['margin']				= $v['fee'] - $v['tot_salescost_admin'];
			$v['margin_percent']		= round($v['margin'] / $v['price'] * 10000) / 100;

			$tot['tot_salescost_admin']				+= $v['tot_salescost_admin'];
			$tot['tot_salescost_provider']			+= $v['tot_salescost_provider'];
			$tot['price']							+= $v['price'];
			$tot['fee']								+= $v['fee'];
			$tot['wcode']							+= $v['wcode'];
			$tot['wemoney']							+= $v['wemoney'];
			$tot['account_price']					+= $v['account_price'];
			$tot['margin']							+= $v['margin'];
			$tot['ea']								+= $v['ea'];
			$tot['shipping_cost_by_shop']		+= $v['shipping_cost_by_shop'];

			$tot_export['shipping_cost_by_shop']		+= $v['shipping_cost_by_shop'];
			$tot_export['tot_salescost_provider']	+= $v['tot_salescost_provider'];
			$tot_export['tot_salescost_admin']		+= $v['tot_salescost_admin'];
			$tot_export['shipping_cost']			+= $v['shipping_cost'];
			$tot_export['goods_shipping_cost']		+= $v['goods_shipping_cost'];
			$tot_export['price']					+= $v['price'];
			$tot_export['fee']						+= $v['fee'];
			$tot_export['wcode']					+= $v['wcode'];
			$tot_export['wemoney']					+= $v['wemoney'];
			$tot_export['account_price']			+= $v['account_price'];
			$tot_export['margin']					+= $v['margin'];
			$tot_export['ea']						+= $v['ea'];

			$loop[] = $v;
		}

		$tot_export['margin_percent'] = round($tot_export['margin'] / $tot_export['price'] * 10000) / 100;

		$query = $this->account_return_detail_query($sc['pay_period'],$sc['account_round'],$sc['export'],$sc['provider'],$migrationCheckDate);
		foreach($query->result_array() as $k){
			if($k['return_shipping_price']){

				list($k['order_user_name'],$k['member_seq'],$k['userid'],$k['mbinfo_rute'],$k['group_name']) = explode('|',$k['memberinfo']);
				$k['mpayment']							= $this->arr_payment[$k['payment']];

				$k['return_shipping_price_by_shop']	= 0;
				if( $k['t_shipping_provider_seq'] != $sc['provider'] ){
					$k['return_shipping_price_by_shop']	= (int) $k['return_shipping_price'];
				}

				$tot['return_shipping_price']			+= $k['return_shipping_price'];
				$tot['return_shipping_price_by_shop']	+= $k['return_shipping_price_by_shop'];
				$tot['account_price']					+= $k['return_shipping_price'];
				$tot['ea']								+= $k['ea'];

				$tot_return['return_shipping_price']	+= $k['return_shipping_price'];
				$tot_return['return_shipping_price_by_shop']	+= $k['return_shipping_price_by_shop'];
				$tot_return['account_price']			+= $k['return_shipping_price'];
				$tot_return['ea']						+= $k['ea'];

				$loop2[]								= $k;
			}
		}

		// 2016.03.02 환불정보에서 상품명 클릭 시 에러 발생 goods_seq을 추가로 가져옴 pjw
		$field_query = "
			A.*,
			opt.ori_price as price,
			sub.price as sub_price,
			ord.order_user_name,
			(SELECT concat(member_seq,'|',userid,'|',rute,'|',(SELECT group_name FROM fm_member_group where group_seq=fm_member.group_seq)) FROM fm_member WHERE member_seq=ord.member_seq) memberinfo,
			opt.option1,opt.option2,opt.option3,opt.option4,opt.option5,
			
			(IFNULL(opt.coupon_sale,0) / IFNULL(opt.ea,0))	as coupon_sale,
			IFNULL(opt.member_sale,0)							as member_sale,
			(IFNULL(opt.fblike_sale,0) / IFNULL(opt.ea,0))	as fblike_sale,
			(IFNULL(opt.mobile_sale,0) / IFNULL(opt.ea,0))	as mobile_sale,
			(IFNULL(opt.promotion_code_sale,0) / IFNULL(opt.ea,0))	as promotion_code_sale,
			(IFNULL(opt.referer_sale,0) / IFNULL(opt.ea,0))	as referer_sale,

			IFNULL(opt.salescost_provider_coupon,0) 	as salescost_provider_coupon,
			IFNULL(opt.salescost_provider_promotion,0) as salescost_provider_promotion,
			IFNULL(opt.salescost_provider_referer,0) as salescost_provider_referer,

			sub.suboption,
			ifnull(cast(opt.commission_price as signed),0) + ifnull(cast(sub.commission_price as signed),0) as commission_price,
			B.ea,
			A.refund_price,
			ord.admin_order,
			ord.payment,
			(select goods_name from fm_order_item where item_seq = B.item_seq) goods_name, 
			(select goods_seq from fm_order_item where item_seq = B.item_seq) goods_seq ";
		$query = $this->account_refund_query($sc['pay_period'],$sc['account_round'],$sc['export'],$sc['provider'],$sc['account_seq'],$field_query,$migrationCheckDate);
		
		foreach($query->result_array() as $v){

			list($v['member_seq'],$v['userid'],$v['mbinfo_rute'],$v['group_name']) = explode('|',$v['memberinfo']);
			$v['price']							= $v['price']*$v['ea'] + $v['sub_price']*$v['ea'];
			$v['fee']							= $v['price'] - ($v['commission_price']*$v['ea']);
			$v['account_price']					= $v['commission_price']*$v['ea'];
			$v['mpayment']						= $this->arr_payment[$v['payment']];

			## 형변환
			$v['coupon_sale']					= (int) ($v['coupon_sale']*$v['ea']);
			$v['member_sale']					= (int) ($v['member_sale']*$v['ea']);
			$v['fblike_sale']					= (int) ($v['fblike_sale']*$v['ea']);
			$v['mobile_sale']					= (int) ($v['mobile_sale']*$v['ea']);
			$v['promotion_code_sale']			= (int) ($v['promotion_code_sale']*$v['ea']);
			$v['referer_sale']					= (int) ($v['referer_sale']*$v['ea']);
			$v['salescost_provider_coupon']		= (int) ($v['salescost_provider_coupon']*$v['ea']);
			$v['salescost_provider_promotion']	= (int) ($v['salescost_provider_promotion']*$v['ea']);
			$v['salescost_provider_referer']	= (int) ($v['salescost_provider_referer']*$v['ea']);

			$goods_sale							= $v['coupon_sale']+$v['member_sale']+$v['fblike_sale']+$v['mobile_sale']+$v['promotion_code_sale']+$v['referer_sale'];
			$goods_provider_sale				= $v['salescost_provider_coupon'] + $v['salescost_provider_promotion'] + $v['salescost_provider_referer'];
			$v['salecost_provider']				= $goods_provider_sale;
			$v['salecost_admin']				= $goods_sale - $goods_provider_sale;
			$v['account_price']					= $v['account_price'] - $v['salecost_provider'];
			$v['margin']						= $v['fee'] - $v['salecost_admin'];

			$tot['price'] 						-= $v['price'];
			$tot['fee'] 						-= $v['fee'];
			$tot['account_price']				-= $v['account_price'];
			$tot['ea']							-= $v['ea'];
			$tot['tot_salescost_admin']			-= $v['salecost_admin'];
			$tot['tot_salescost_provider']		-= $v['salecost_provider'];

			$tot_refund['price']				-= $v['price'];
			$tot_refund['fee']					-= $v['fee'];
			$tot_refund['account_price']		-= $v['account_price'];
			$tot_refund['ea']					+= $v['ea'];
			$tot_refund['margin']				-= $v['margin'];
			$tot_refund['salecost_admin']		+= $v['salecost_admin'];
			$tot_refund['salecost_provider']	+= $v['salecost_provider'];

			$v['refund_shipping_price']			= 'N';

			//배송비 환불의 경우  처리
			if($v['refund_type'] == 'shipping_price'){
				$v['refund_shipping_price']	= 'Y';
				$v['goods_name']			= '배송비 환불';

				//debug($v);
				$v['option1']				= '';
				$v['option2']				= '';
				$v['option3']				= '';
				$v['option4']				= '';
				$v['option5']				= '';
				$v['account_price']			= $v['refund_delivery'];
				
				//화면 노출용 추가
				$tot_refund['refund_delivery']			+= $v['refund_delivery'];
				$tot_return['return_shipping_price']	+= $v['refund_delivery'];
				$tot_refund['account_price']			+= $v['account_price'];
				$tot['account_price']					-= $v['refund_delivery'];
				//$tot_refund['fee']						-= $v['refund_delivery'];

			}

			$loop3[]						= $v;

		}
		$tot['shipping_price']		= $tot_export['goods_shipping_cost'] + $tot_export['shipping_cost'] - $tot_return['return_shipping_price'];
		$tot['margin']				= $tot['margin'] + $tot_refund['margin'];
		if ( $tot['price'] == 0 ) {
			$tot['margin_percent'] = 0;
		} else {
			$tot['margin_percent']	= round($tot['margin'] / $tot['price'] * 10000) / 100;
		}

		$result = array();
		$result['loop']			= $loop;
		$result['loop2']		= $loop2;
		$result['loop3']		= $loop3;
		$result['tot_return']	= $tot_return;
		$result['tot_refund']	= $tot_refund;
		$result['tot_export']	= $tot_export;
		$result['tot']			= $tot;

		return $result;

	}

	public function period2date($period_type,$round,$date){
		$r_date = explode('-',$date);
		$st = mktime(0, 0, 0, $r_date[1], 1, $r_date[0]);
		$endday = date('t',$st);
		if($period_type == '2'){
			if($round == 1){
				$ret[] = $date."-01";
				$ret[] = $date."-15";
			}else{
				$ret[] = $date."-16";
				$ret[] = $date."-".$endday;
			}
		}else if($period_type == '4'){
			if($round == 1){
				$ret[] = $date."-01";
				$ret[] = $date."-07";
			}else if($round == 2){
				$ret[] = $date."-08";
				$ret[] = $date."-14";
			}else if($round == 3){
				$ret[] = $date."-15";
				$ret[] = $date."-21";
			}else{
				$ret[] = $date."-22";
				$ret[] = $date."-".$endday;
			}
		}else{
			$ret[] = $date."-01";
			$ret[] = $date."-".$endday;
		}

		return $ret;
	}
	
	public function set_account_key($provider_seq,$start,$end){
		$tmp[] = $provider_seq;
		$tmp[] = substr(str_replace('-','',$start),0,8);
		$tmp[] = substr(str_replace('-','',$end),0,8);
		return implode('/',$tmp);
	}

	public function get_account_refund_request($start_date,$end_date,$provider_seq='',$migrationCheckDate=''){
		$bind[] = $start_date;
		$bind[] = $end_date;
		if( $provider_seq ){
			$where_arr[] = "C.provider_seq=?";
			$bind[] = $provider_seq;
		}
		
		// @20190514 pjm 구정산 노출 기준 : 신정산 마이그레이션 날짜 이전 주문(결제)건만 노출.
		if($migrationCheckDate){
			$where_arr[] = "ord.deposit_date < '".$migrationCheckDate."'";
		}

		if($where_arr){
			$where_str = ' AND '.implode(' AND ',$where_arr);
		}
		$query = "SELECT
				C.provider_seq,
				sum(B.ea) refund_ea,
				sum(ifnull(opt.ori_price*B.ea,0)+ifnull(sub.price*B.ea,0)) + 
				sum(if(A.refund_type = 'shipping_price', A.refund_delivery, 0))  as refund_price,
				sum(ifnull(cast(opt.commission_price as signed)*cast(B.ea as signed),0) +
				ifnull(cast(sub.commission_price as signed)*cast(B.ea as signed),0)) +
				sum(if(A.refund_type = 'shipping_price', A.refund_delivery, 0)) as refund_commission_price,
				sum( (ifnull(opt.ori_price,0)-ifnull(opt.commission_price,0)) * B.ea + (ifnull(sub.price,0)-ifnull(sub.commission_price,0)) * B.ea ) as refund_fee,
				sum( ifnull(opt.member_sale,0) * B.ea )									as refund_member_sale,
				sum( (ifnull(opt.fblike_sale,0) / ifnull(opt.ea,0)) * B.ea )				as refund_fblike_sale,
				sum( (ifnull(opt.mobile_sale,0)/ifnull(opt.ea,0)) * B.ea )				as refund_mobile_sale,
				sum( (ifnull(opt.promotion_code_sale,0)/ifnull(opt.ea,0)) * B.ea )	as refund_promotion_code_sale,
				sum( (ifnull(opt.referer_sale,0)/ifnull(opt.ea,0)) * B.ea )				as refund_referer_sale,
				sum( (ifnull(opt.coupon_sale,0)/ifnull(opt.ea,0)) * B.ea )				as refund_coupon_sale,
				sum( ifnull(opt.salescost_provider_coupon,0) * B.ea )					as refund_salescost_provider_coupon,
				sum( ifnull(opt.salescost_provider_promotion,0) * B.ea )				as refund_salescost_provider_promotion,
				sum( ifnull(opt.salescost_provider_referer,0) * B.ea )					as refund_salescost_provider_referer
		FROM
			fm_order_refund A
			LEFT JOIN fm_order_refund_item B ON A.refund_code = B.refund_code
			LEFT JOIN fm_order_item_option opt ON opt.item_option_seq = B.option_seq and B.option_seq and (B.suboption_seq is null or B.suboption_seq ='')
			LEFT JOIN fm_order_item_suboption sub ON sub.item_suboption_seq = B.suboption_seq and B.suboption_seq
			,fm_order_item C
			,fm_order ord
		WHERE
			A.refund_type in ('return','shipping_price')
			AND A.status = 'complete'
			AND C.item_seq = B.item_seq
			AND ord.order_seq=A.order_seq
			AND A.refund_date between ? and ?
			AND A.account_seq is null
			AND C.provider_seq != 1
			".$where_str."
			GROUP BY C.provider_seq";
		return $this->db->query($query,$bind);
	}
	
	public function get_account_return_request($start_date,$end_date,$provider_seq='',$migrationCheckDate){
		$bind[] = $start_date;
		$bind[] = $end_date;
		if( $provider_seq ){
			$where_arr[] = "c.provider_seq=?";
			$bind[] = $provider_seq;
		}
		// @20190514 pjm 구정산 노출 기준 : 신정산 마이그레이션 날짜 이전 주문(결제)건만 노출.
		if($migrationCheckDate){
			$where_arr[] = "ord.deposit_date < '".$migrationCheckDate."'";
		}

		if($where_arr){
			$where_str = ' AND '.implode(' AND ',$where_arr);
		}

		$query = "
		select
			sum(tb.return_shipping_price) as return_shipping_price, tb.shipping_provider_seq, tb.shipping_provider_seq as provider_seq
		from (
			select t1.return_code,t2.shipping_provider_seq,t1.return_shipping_price
			from
				fm_order_return t1,
				(
					select
						a.return_code, e.shipping_provider_seq
					from
						fm_order_return a,
						fm_order_return_item b,
						fm_order_item c,
						fm_order as ord,
						fm_goods_export_item d,
						fm_goods_export e
					where
						a.return_code=b.return_code
						and b.item_seq = c.item_seq
						and b.option_seq = d.option_seq
						and d.export_code=e.export_code
						and a.return_date between ? and ?
						and a.return_shipping_price > 0
						and a.`status`='complete'
						and e.shipping_provider_seq != '1'
						and a.account_seq is null
						and ord.order_seq=c.order_seq
						".$where_str."
				) t2
			where
				t1.return_code=t2.return_code
			group by t1.return_code
		) tb group by tb.shipping_provider_seq
		";
		$query = $this->db->query($query,$bind);
		return $query;
	}

	public function get_account_request($params,$mode='catalog'){
		
		$this->load->helper('accountall');		

		$_accountSettings			= getAccountSetting();
		$migrationCheckDate			= $_accountSettings['migrationCheckDate'];

		$where = array();

		// @20190514 pjm 구정산 노출 기준 : 신정산 마이그레이션 날짜 이전 주문(결제)건만 노출.
		if($migrationCheckDate){
			$where[] = "ord.deposit_date < '".$migrationCheckDate."'";
		}

		if( $mode == 'catalog' ){
			if(!$params['s_year'] && !$params['e_year']){
				$date_arr			= explode("-",date("Y-m"));
				$params['s_year']	= $date_arr[0];
				$params['s_month']	= $date_arr[1];
				$params['e_year']	= $date_arr[0];
				$params['e_month']	= $date_arr[1];
			}
			$params['s_export']	= $params['s_year']."-".$params['s_month'];
			$params['e_export']	= $params['e_year']."-".$params['e_month'];
			$account_date[0]	= $params['s_export'];
			$account_date[1]	= $params['e_export'];
			if(isset($params['s_export']) && $params['s_export']!="" && isset($params['e_export']) && $params['e_export']!=""){
				$where_shipping_date_str	= "substring( exp.shipping_date, 1, 7 ) between '{$params['s_export']}' and '{$params['e_export']}' ";
			}
			if(isset($params['provider_seq']) && $params['provider_seq']!=""){
				$where[]	= " oitem.provider_seq = '{$params['provider_seq']}' ";
			}
			if($params['pay_period']==2){
				$field_period	= ",exp.account_2round as account_round";
				$groupby_period	= ",account_round";
				$where[]		= "pvd.calcu_count=2";
				$account_round	= "account_2round";
			}else if($params['pay_period'] == 4){
				$field_period	= ",exp.account_4round as account_round";
				$groupby_period	= ",account_round";
				$where[]		= "pvd.calcu_count=4";
				$account_round	= "account_4round";
			}else{
				$where[]		= "(pvd.calcu_count=1 OR pvd.calcu_count is null)";
			}
			if($where){
				$str_where	= ' and '. $where_shipping_date_str . ' and ' . implode(' and ',$where);
			}
		}
		if( $mode == 'process' ){
			if(  $params['value'] == 'none' ){
				$callback = "parent.location.reload();";
				openDialogAlert("대기상태로는 변경하실 수 없습니다.",400,140,'parent',$callback);
				exit;
			}
			$r_period = $this->period2date($params['pay_period'],$params['account_round'],$params['export']);
			
			if( $r_period[1] >= date('Y-m-d')){
				openDialogAlert("\'".$r_period[1]."\'이 지나야 정산하실수 있습니다.",400,140,'parent',$callback);
				exit;
			}
			
			$account_date[0] = $r_period[0];
			$account_date[1] = $r_period[1];

			if($account_date[0] && $account_date[1]){
				$where_shipping_date_str = "substring( exp.shipping_date, 1, 10 ) between '".$account_date[0]."' and '".$account_date[1]."'";
			}

			$params['provider_seq'] = $params['provider'];
			$shipping_provider_seq = $params['provider_seq'];
			if(isset($params['provider_seq']) && $params['provider_seq']!=""){
				$where[] = " oitem.provider_seq = '{$shipping_provider_seq}' ";
			}
			$period_type = 1;
			if($params['pay_period']) $period_type = $params['pay_period'];

			if($params['pay_period']==2){
				$field_period = ",exp.account_2round as account_round";
				$groupby_period = ",account_round";
				$where[] = "pvd.calcu_count=2";
				$account_round = "account_2round";
			}else if($params['pay_period']==4){
				$field_period = ",exp.account_4round as account_round";
				$groupby_period = ",account_round";
				$where[] = "pvd.calcu_count=4";
				$account_round = "account_4round";
			}else{
				$where[] = "(pvd.calcu_count=1 OR pvd.calcu_count is null)";
			}
			if($where) $str_where = ' and '. $where_shipping_date_str . ' and ' . implode(' and ',$where);
		}
		
		// 정산기간구하기
		$begin	= new DateTime($account_date[0].'-01 00:00:00');
		$end	= new DateTime($account_date[1].'-01 00:00:00');
		while($begin->format('Y-m')	<= $end->format('Y-m')){
			$account_months[] = $begin->format('Y-m');
			$begin->modify('+1 month');
		}
		foreach($account_months as $account_date){
			$begin = new DateTime($account_date.'-01 00:00:00');
			if($params['pay_period'] == 2){
				$date[0]['start']	= $begin->format('Y-m-d H:i:s');
				$begin->modify('+14 day');
				$date[0]['end']		= $begin->format('Y-m-d 23:59:59');
				$begin->modify('+1 day');
				$date[1]['start']	= $begin->format('Y-m-d H:i:s');
				$date[1]['end']		= $begin->format('Y-m-t 23:59:59');
			}else if($params['pay_period'] == 4){
				$date[0]['start']	= $begin->format('Y-m-d H:i:s');
				$begin->modify('+6 day');
				$date[0]['end']		= $begin->format('Y-m-d 23:59:59');
				$begin->modify('+1 day');
				$date[1]['start']	= $begin->format('Y-m-d H:i:s');
				$begin->modify('+6 day');
				$date[1]['end']		= $begin->format('Y-m-d 23:59:59');
				$begin->modify('+1 day');
				$date[2]['start']	= $begin->format('Y-m-d H:i:s');
				$begin->modify('+6 day');
				$date[2]['end']		= $begin->format('Y-m-d 23:59:59');
				$begin->modify('+1 day');
				$date[3]['start']	= $begin->format('Y-m-d H:i:s');
				$date[3]['end']		= $begin->format('Y-m-t 23:59:59');
			}else{
				$date[0]['start']	= $begin->format('Y-m-d H:i:s');
				$date[0]['end']		= $begin->format('Y-m-t 23:59:59');
			}
			$loop_dates[$account_date] = $date;
		}
		
		$loop = array();
		$data_acc = array();
		$sql = "
			SELECT
				substring( shipping_date, 1, 7 )	as export,
				sum(item.ea)						as export_ea,
				sum(opt.ori_price*item.ea)			as opt_price,
				sum(sub.price*item.ea)				as sub_price,
				(sum(ifnull(cast(opt.commission_price as signed)*cast(item.ea as signed),0)) + sum(ifnull(cast(sub.commission_price as signed)*cast(item.ea as signed),0)))	as commission_price,
				sum(opt.member_sale*ifnull(item.ea,0))	as member_sale,
				sum(opt.coupon_sale)					as coupon_sale,
				sum(opt.promotion_code_sale)			as promotion_code_sale,
				sum(opt.fblike_sale)					as fblike_sale,
				sum(opt.mobile_sale)					as mobile_sale,
				sum(opt.referer_sale)					as referer_sale,

				sum(IFNULL(opt.salescost_provider_coupon,0) * IFNULL(item.ea,0))	as salescost_provider_coupon,
				sum(IFNULL(opt.salescost_provider_promotion,0) * IFNULL(item.ea,0))	as salescost_provider_promotion,
				sum(IFNULL(opt.salescost_provider_referer,0) * IFNULL(item.ea,0))	as salescost_provider_referer,

				sum(opt.promotion_code_sale)	as wcode,
				sum(ifnull(item.ea,0))			as ea,
				oitem.provider_seq,

				sum(IFNULL(opt.unit_emoney,0)*IFNULL(item.ea,0) + IFNULL(sub.unit_emoney,0)*IFNULL(item.ea,0))	as emoney,
				sum(IFNULL(opt.unit_cash,0)*IFNULL(item.ea,0) + IFNULL(sub.unit_cash,0)*IFNULL(item.ea,0))	as cash,
				sum(IFNULL(opt.unit_enuri,0)*IFNULL(item.ea,0) + IFNULL(sub.unit_enuri,0)*IFNULL(item.ea,0))	as enuri

				".$field_period."
			FROM
				fm_goods_export_item item
				LEFT JOIN fm_order_item_option opt ON opt.item_option_seq = item.option_seq and item.option_seq
				LEFT JOIN fm_order_item_suboption sub ON sub.item_suboption_seq = item.suboption_seq and item.suboption_seq
				LEFT JOIN fm_goods_export exp ON exp.export_code=item.export_code
				LEFT JOIN fm_order ord ON ord.order_seq=exp.order_seq
				LEFT JOIN fm_order_item oitem ON oitem.item_seq=item.item_seq
				LEFT JOIN fm_provider pvd ON pvd.provider_seq = oitem.provider_seq
			WHERE
				exp.status = '75'
				and (ord.linkage_id is null or ord.linkage_id != 'connector')
				and ord.orign_order_seq is null
				and (exp.account_seq is null or exp.account_seq ='' )
				AND oitem.provider_seq!=1
				".$str_where."
			GROUP BY
				oitem.provider_seq, export".$groupby_period."
			ORDER BY
				oitem.provider_seq desc";
		$query = $this->db->query($sql);
		foreach($query->result_array() as $data_acc){
			$tmp_period = $this->period2date($params['pay_period'],$data_acc['account_round'],$data_acc['export']);
			$account_key = $this->set_account_key($data_acc['provider_seq'],$tmp_period[0],$tmp_period[1]);
			$data_acc['shipping_cost_by_shop']			= 0;
			$data_acc['return_shipping_price_by_shop']	= 0;
			$data_acc['shipping_cost']					= 0;
			$data_acc['shipping_provider_coupon']		= 0;
			$data_acc['shipping_provider_promotion']	= 0;
			
			$query_shipping = $this -> account_order_shipping_query($params['pay_period'],$data_acc['account_round'],$data_acc['export'],$data_acc['provider_seq'],$migrationCheckDate);
			foreach($query_shipping -> result_array() as $data_shipping){
				
				if(in_array($data_shipping['shipping_method'], $this->_arr_shipping_type)){
					$data_acc['shipping_cost']	+= $data_shipping['shipping_cost'];
					$data_acc['coupon_sale']	+= $data_shipping['shipping_coupon_sale'];
					$data_acc['shipping_provider_coupon']	+= $data_shipping['salescost_provider_coupon'];
					$data_acc['salescost_provider_coupon']	+= $data_acc['shipping_provider_coupon'];
					$data_acc['promotion_code_sale']	+= $data_shipping['shipping_promotion_code_sale'];
					$data_acc['shipping_provider_promotion']	+= $data_shipping['salescost_provider_promotion'];
					$data_acc['salescost_provider_promotion']	+= $data_acc['shipping_provider_promotion'];

					if( $data_shipping['provider_seq'] != $data_acc['provider_seq'] ){
						$data_acc['shipping_cost_by_shop']	+= (int) $data_shipping['shipping_cost'];
					}
				}
				if($data_shipping['shipping_method']=='each_delivery'){
					$data_acc['goods_shipping_cost']	+= (int) $data_shipping['delivery_cost'];
					$data_acc['goods_shipping_cost']	+= (int) $data_shipping['add_delivery_cost'];
					if( $data_shipping['provider_seq'] != $data_acc['provider_seq'] ){
						$data_acc['shipping_cost_by_shop']	+= (int) $data_shipping['delivery_cost'];
						$data_acc['shipping_cost_by_shop']	+= (int) $data_shipping['add_delivery_cost'];
					}
				}
			}
			$data_acc['total_shipping_cost_by_shop']	+= $data_acc['shipping_cost_by_shop'];
			$loop[$account_key] = $data_acc;
			$is_data[$account_key] = true;
		}

		## 환불금액
		$loop_refund = array();
		$data_acc = array();
		foreach($loop_dates as $account_month){
			foreach($account_month as $key => $account_date){
				if( $r_period[0] && $r_period[1] && (substr($account_date['start'],0,10) != $r_period[0] || substr($account_date['end'],0,10) != $r_period[1]) ){
					continue;
				}
				$query_refund = $this->accountmodel->get_account_refund_request($account_date['start'],$account_date['end'],$params['provider_seq'],$migrationCheckDate);
				foreach($query_refund->result_array() as $data_acc_refund){
					
					$account_key = $this->set_account_key($data_acc_refund['provider_seq'],$account_date['start'],$account_date['end']);
					$data_acc['provider_seq']				= $data_acc_refund['provider_seq'];
					$data_acc['refund_ea']					= $data_acc_refund['refund_ea'];
					$data_acc['refund_price']				= $data_acc_refund['refund_price'];
					$data_acc['refund_commission_price']	= $data_acc_refund['refund_commission_price'];
					if($data_acc_refund['refund_commission_price']){
						$data_acc['refund_fee'] = $data_acc_refund['refund_price'] - $data_acc_refund['refund_commission_price'];
					}
					$data_acc['refund_fee']					= $data_acc_refund['refund_fee'];

					$data_acc['refund_coupon_sale']					= $data_acc_refund['refund_coupon_sale'];
					$data_acc['refund_member_sale']				= $data_acc_refund['refund_member_sale'];
					$data_acc['refund_fblike_sale']					= $data_acc_refund['refund_fblike_sale'];
					$data_acc['refund_mobile_sale']					= $data_acc_refund['refund_mobile_sale'];
					$data_acc['refund_promotion_code_sale']		= $data_acc_refund['refund_promotion_code_sale'];
					$data_acc['refund_referer_sale']					= $data_acc_refund['refund_referer_sale'];
					$data_acc['refund_salescost_provider_coupon']		= $data_acc_refund['refund_salescost_provider_coupon'];
					$data_acc['refund_salescost_provider_promotion']	= $data_acc_refund['refund_salescost_provider_promotion'];
					$data_acc['refund_salescost_provider_referer']		= $data_acc_refund['refund_salescost_provider_referer'];

					$data_acc['account_round'] = $key+1;
					$loop_refund[$account_key] = $data_acc;
					$is_data[$account_key] = true;
				}
			}
		}

		// 반품배송비
		$loop_return = array();
		$data_acc = array();
		foreach($loop_dates as $account_month){
			foreach($account_month as $key => $account_date){
				$data_acc['return_shipping_price']			= 0;
				$data_acc['return_shipping_price_by_shop']	= 0;
				if( $r_period[0] && $r_period[1] && (substr($account_date['start'],0,10) != $r_period[0] || substr($account_date['end'],0,10) != $r_period[1]) ){
					continue;
				}
				$query_shipping = $this->accountmodel->get_account_return_request($account_date['start'],$account_date['end'],$params['provider_seq'],$migrationCheckDate);
				foreach($query_shipping -> result_array() as $data_shipping){
					$account_key = $this->set_account_key($data_shipping['provider_seq'],$account_date['start'],$account_date['end']);
					$data_acc['return_shipping_price']	= $data_shipping['return_shipping_price'];//배송그룹 반품/교환배송비 합계@2017-05-26
					if( $data_shipping['shipping_provider_seq'] != $data_shipping['provider_seq'] ){
						$data_acc['return_shipping_price_by_shop'] += $data_shipping['return_shipping_price'];
					}
					$data_acc['account_round'] = $key+1;
					$loop_return[$account_key] = $data_acc;
					$is_data[$account_key] = true;
				}
			}
		}

		foreach($is_data as $account_key => $tmp){
			$tmp_key = explode('/',$account_key);
			$provider_seq = $tmp_key[0];
			$data_acc = array_merge((array)$loop[$account_key],(array)$loop_refund[$account_key],(array)$loop_return[$account_key]);
			
			$pay_period = $params['pay_period'];
			if(!$pay_period) $pay_period = 2;
			$data_provider = $this->providermodel->get_provider($provider_seq);
			if(!$data_provider['calcu_count']) $data_provider['calcu_count'] = 1;
			$data_acc['provider_seq']	= $data_provider['provider_seq'];
			$data_acc['provider_name']	= $data_provider['provider_name'];
			$data_acc['provider_id']	= $data_provider['provider_id'];
			
			$tmp_period = explode('/',$account_key);
			$data_acc['period'] = $tmp_period[1];
			if($tmp_period[2]) $data_acc['period'] .= " ~ " . $tmp_period[2];
			$data_acc['export'] = substr($tmp_period[1],0,4).'-'.substr($tmp_period[1],4,2);
			$data_acc['total_shipping_cost_by_shop']	+= $data_acc['return_shipping_price_by_shop'];

			## 할인부담금 관련 추가
			$data_acc['refund_salecost'] 		= $data_acc['refund_coupon_sale'] + $data_acc['refund_member_sale'] 
													+ $data_acc['refund_fblike_sale'] + $data_acc['refund_mobile_sale']
													+ $data_acc['refund_promotion_code_sale'] + $data_acc['refund_referer_sale'];
			$data_acc['tot_refund_salecost_admin']	= $data_acc['refund_salecost'] - $data_acc['refund_salescost_provider'];

			$data_acc['tot_salescost']			= $data_acc['coupon_sale'] + $data_acc['member_sale'] + $data_acc['fblike_sale']
													+ $data_acc['mobile_sale'] + $data_acc['promotion_code_sale'] 
													+ $data_acc['referer_sale'] + $data_acc['enuri'] - $data_acc['refund_salecost'];

			$data_acc['salescost_provider']	= $data_acc['salescost_provider_coupon'] 
													+ $data_acc['salescost_provider_promotion'] 
													+ $data_acc['salescost_provider_referer'];
			$data_acc['tot_salescost_provider']	= $data_acc['salescost_provider'] - $data_acc['refund_salescost_provider'];

			$total_salescost						= $data_acc['coupon_sale'] + $data_acc['member_sale'] + $data_acc['fblike_sale']
													+ $data_acc['mobile_sale'] + $data_acc['promotion_code_sale'] 
													+ $data_acc['referer_sale'] + $data_acc['enuri'];

			$total_salescost_admin					= $total_salescost - $data_acc['salescost_provider'];
			$data_acc['tot_salescost_admin'] = $data_acc['tot_salescost'] - $data_acc['tot_salescost_provider'];
			$data_acc['admin_coupon_sale'] = $data_acc['coupon_sale'] - $data_acc['salescost_provider_coupon'];
			$data_acc['admin_promotion_sale'] = $data_acc['promotion_code_sale'] - $data_acc['salescost_provider_promotion'];
			$data_acc['admin_referer_sale'] = $data_acc['referer_sale'] - $data_acc['salescost_provider_referer'];
			$data_acc['wmoney']	= $data_acc['emoney'] + $data_acc['cash'];
			$data_acc['price'] = $data_acc['opt_price'] + $data_acc['sub_price'];
			$data_acc['shipping'] = $data_acc['shipping_cost'] + $data_acc['goods_shipping_cost'];
			
			/*$data_acc['fee']						= $data_acc['price'] + $data_acc['shipping_provider_coupon'] + $data_acc['shipping_provider_promotion']
													- $data_acc['commission_price'] - $data_acc['salescost_provider'];		*/
			$data_acc['fee']						= $data_acc['price'] - $data_acc['commission_price'];
			$data_acc['tot_fee']					= $data_acc['fee'] - $data_acc['refund_fee'];		//수수료
			$data_acc['sales'] = $data_acc['price'] - $data_acc['refund_price'];

			//총 정산금액 = 판매가+배송비+반품배송비 - 본사수수료-환불정산금액-입점사부담할인액-
			$data_acc['account_price']	= (int) $data_acc['price'] 
				+ (int) $data_acc['shipping'] 
				+ (int) $data_acc['return_shipping_price'] 
				- (int) $data_acc['fee'] 
				- (int) $data_acc['refund_commission_price'] 
										- (int) $data_acc['salescost_provider'] 
				- (int) $data_acc['total_shipping_cost_by_shop'];
			//$data_acc['margin']	= $data_acc['tot_fee'] - $data_acc['tot_salescost_admin'];

			$margin_plus	= $data_acc['fee'] - $total_salescost_admin;
			$margin_minus	= $data_acc['refund_fee'] - $data_acc['tot_refund_salecost_admin'];

			//마진 : 총 수수료 - 본사 할인액 - 환불해준 입점사 할인액
			$data_acc['margin']	= $margin_plus - $margin_minus;
			if ( $data_acc['price']-$data_acc['refund_price'] == 0 ) {
				$data_acc['margin_percent'] = 0;
			} else {
				$data_acc['margin_percent'] = round( $data_acc['margin'] / ($data_acc['price']-$data_acc['refund_price']) * 10000 ) / 100;
			}
			## 정산주기 체크
			if( $pay_period == $data_provider['calcu_count'] )  $result[] = $data_acc;
		}
		return $result;
	}

	public function reverse($account_seq){
		$query = "select * from fm_account where seq = ?";
		$query = $this->db->query($query,array($account_seq));
		foreach($query->result_array() as $data_acc){			
			$uquery = "update fm_order_item set account_date=null,account_seq=null where account_seq=?";
			$this->db->query($uquery,array($data_acc['seq']));
			$uquery = "update fm_goods_export set account_date=null,account_gb='none',account_seq=null where account_seq=?";
			$this->db->query($uquery,array($data_acc['seq']));
			$uquery = "update fm_order_return set account_seq=null where account_seq=?";
			$this->db->query($uquery,array($data_acc['seq']));
			$uquery = "update fm_order_refund set account_seq=null where account_seq=?";
			$this->db->query($uquery,array($data_acc['seq']));
			$uquery = "update fm_order_shipping set account_seq=null where account_seq=?";
			$this->db->query($uquery,array($data_acc['seq']));
			$dquery = "delete from fm_account where seq=?";
			$this->db->query($dquery,array($data_acc['seq']));
		}
	}

	public function get_issue_count($period,$start_date){
		$field_period = '';
		$account_round = '';
		$groupby_period = '';
		$where = array();

		if($period==2){
			$field_period = ",exp.account_2round as account_round";
			$groupby_period = ",account_round";
			$where[] = "pvd.calcu_count=2";
			$account_round = "account_2round";
		}else if($period==4){
			$field_period = ",exp.account_4round as account_round";
			$groupby_period = ",account_round";
			$where[] = "pvd.calcu_count=4";
			$account_round = "account_4round";
		}else{
			$where[] = "(pvd.calcu_count=1 OR pvd.calcu_count is null)";
		}

		if($where){
			$str_where = "AND ".implode(' AND ',$where);
		}

		$query = "
			SELECT count(*) cnt from (
			SELECT
				substring( shipping_date, 1, 7 ) export					
				".$field_period."
			FROM
				fm_goods_export_item item
				LEFT JOIN fm_order_item_option opt ON opt.item_option_seq = item.option_seq and item.option_seq
				LEFT JOIN fm_order_item_suboption sub ON sub.item_suboption_seq = item.suboption_seq and item.suboption_seq
				LEFT JOIN fm_goods_export exp ON exp.export_code=item.export_code
				LEFT JOIN fm_order ord ON ord.order_seq=exp.order_seq
				LEFT JOIN fm_order_item oitem ON oitem.item_seq=item.item_seq
				LEFT JOIN fm_provider pvd ON pvd.provider_seq = oitem.provider_seq
			WHERE
				exp.status = '75'
				and ord.orign_order_seq is null
				AND exp.shipping_provider_seq!=1
				and exp.account_date is null
				and ord.regist_date>=?
				and (ord.linkage_id is null or ord.linkage_id != 'connector')
				".$str_where."
			GROUP BY
				exp.shipping_provider_seq,export".$groupby_period.") t";
		
		return $this->db->query($query,array($start_date));
		
	}
	public function get_issue_count_provider($period,$start_date,$provider_seq){
		$field_period = '';
		$account_round = '';
		$groupby_period = '';
		$where = array();

		if($period==2){
			$field_period = ",exp.account_2round as account_round";
			$groupby_period = ",account_round";
			$where[] = "pvd.calcu_count=2";
			$account_round = "account_2round";
		}else if($period==4){
			$field_period = ",exp.account_4round as account_round";
			$groupby_period = ",account_round";
			$where[] = "pvd.calcu_count=4";
			$account_round = "account_4round";
		}else{
			$where[] = "(pvd.calcu_count=1 OR pvd.calcu_count is null)";
		}

		if($where){
			$str_where = "AND ".implode(' AND ',$where);
		}

		$query = "
			SELECT count(*) cnt from (
			SELECT
				substring( shipping_date, 1, 7 ) export
				".$field_period."
			FROM
				fm_goods_export_item item
				LEFT JOIN fm_order_item_option opt ON opt.item_option_seq = item.option_seq and item.option_seq
				LEFT JOIN fm_order_item_suboption sub ON sub.item_suboption_seq = item.suboption_seq and item.suboption_seq
				LEFT JOIN fm_goods_export exp ON exp.export_code=item.export_code
				LEFT JOIN fm_order ord ON ord.order_seq=exp.order_seq
				LEFT JOIN fm_order_item oitem ON oitem.item_seq=item.item_seq
				LEFT JOIN fm_provider pvd ON pvd.provider_seq = oitem.provider_seq
			WHERE
				exp.status = '75'
				and ord.orign_order_seq is null
				AND exp.shipping_provider_seq!=1
				AND exp.account_date is null
				AND ord.regist_date>=?
				and (ord.linkage_id is null or ord.linkage_id != 'connector')
				".$str_where."
				AND oitem.provider_seq = ?
			GROUP BY
				exp.shipping_provider_seq,export".$groupby_period.") t";
		
		return $this->db->query($query,array($start_date,$provider_seq));
		
	}
}

/* End of file accountmodel.php */
/* Location: ./app/models/accountmodel.php */
