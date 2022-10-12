<?php
require_once(APPPATH ."models/scmbasicmodel".EXT);
class scmmodel extends scmbasicmodel {
	public function get_manager($sc){
		/* nothing done */
	}
	public function save_manager($parent_table, $parent_seq, $params){
		/* nothing done */
	}
	public function get_trader_group(){
		/* nothing done */
	}
	public function get_trader($sc){
		/* nothing done */
	}
	public function chk_trader_params($params){
		/* nothing done */
	}
	public function save_trader($params, $trader_seq = 0){
		/* nothing done */
	}
	public function chk_remove_trader($trader_seq){
		/* nothing done */
	}
	public function remove_trader($trader_seq){
		/* nothing done */
	}
	public function get_warehouse($sc = array()){
		/* nothing done */
	}
	public function get_warehouse_group(){
		/* nothing done */
	}
	public function chk_warehouse_params($params){
		/* nothing done */
	}
	public function save_warehouse($params, $wh_seq = 0){
		/* nothing done */
	}
	public function chk_remove_warehouse($wh_seq){
		/* nothing done */
	}
	public function remove_warehouse($wh_seq){
		/* nothing done */
	}
	public function get_warehouse_stock($wh_seq, $getType = '', $returnType = '', $optioninfo = array()){
		/* nothing done */
	}
	public function save_location($params, $wh_seq){
		/* nothing done */
	}
	public function get_location($sc){
		/* nothing done */
	}
	public function get_location_stock($sc){
		/* nothing done */
	}
	public function get_location_goods($sc){
		/* nothing done */
	}
	public function get_location_goods_for_option($sc, $option_type = '', $list_type = 'warehouse'){
		/* nothing done */
	}
	public function save_location_link($params, $whrParam = array()){
		/* nothing done */
	}
	public function delete_location_link($wh_seq, $goods_seq, $option_seq, $option_type = 'option'){
		/* nothing done */
	}
	public function get_stock_warehouse_list($goods_seq, $option_type, $option_seq){
		/* nothing done */
	}
	public function get_goods_default_order_data($sc){
		/* nothing done */
	}
	public function get_default_supply_goods_info($goods_seq){
		/* nothing done */
	}
	public function get_default_sorder_info($goods_seq, $option_seq, $option_type = 'option', $trader_seq = ''){
		/* nothing done */
	}
	public function get_order_defaultinfo($sc){
		/* nothing done */
	}
	public function chk_order_defaultinfo($params){
		/* nothing done */
	}
	public function save_defaultinfo($defaultinfo){
		/* nothing done */
	}
	public function delete_defaultinfo($goods_seq, $delSeq){
		/* nothing done */
	}
	public function save_defaultinfo_log($params){
		/* nothing done */
	}
	public function get_defaultinfo_log($goodsSeq){
		/* nothing done */
	}
	public function save_scm_auto_warehousing($goods_seq, $scm_auto_warehousing){
		/* nothing done */
	}
	public function save_scm_category($goods_seq, $scm_category){
		/* nothing done */
	}
	public function get_latest_defaultinfo($sc){
		/* nothing done */
	}
	public function chg_taxuse_to_currency(){
		/* nothing done */
	}
	public function auto_order_to_order($order_seq){
		/* nothing done */
	}
	public function auto_order_goods($option_type, $order_option_seq){
		/* nothing done */
	}
	public function save_autosorder_goods($goodsinfo, $orderoption, $goodsoption, $compulsion = false){
		/* nothing done */
	}
	public function get_auto_order_goods($sc){
		/* nothing done */
	}
	public function auto_order_complete($aooSeq){
		/* nothing done */
	}
	public function get_revision_list($sc){
		/* nothing done */
	}
	public function get_revision_goods($sc){
		/* nothing done */
	}
	public function chk_revision_params($params){
		/* nothing done */
	}
	public function save_stock_revision($params, $revision_seq = 0){
		/* nothing done */
	}
	public function save_stock_revision_goods($revision, $goodsData, $exec){
		/* nothing done */
	}
	public function chk_remove_revision($revision_seq){
		/* nothing done */
	}
	public function remove_revision($revision_seq){
		/* nothing done */
	}
	public function get_tmp_revision($tmp_seq, $goods_seq, $option_seq){
		/* nothing done */
	}
	public function create_tmp_revision($tmp_seq, $goods_seq, $option_seq, $data = array()){
		/* nothing done */
	}
	public function delete_tmp_revision($tmp_seq, $goods_seq, $option_seq = '', $revision_seq = ''){
		/* nothing done */
	}
	public function tmp_save_cell_data($revision_seq, $updParams){
		/* nothing done */
	}
	public function tmp_save_all_revision($post){
		/* nothing done */
	}
	public function save_batch_revision($tmp_seq, $savedData){
		/* nothing done */
	}
	public function get_stock_move_goods($sc){
		/* nothing done */
	}
	public function get_stock_move($sc){
		/* nothing done */
	}
	public function chk_stockmove_param($params){
		/* nothing done */
	}
	public function save_stockmove($params, $move_seq = ''){
		/* nothing done */
	}
	public function save_stockmove_goods($move_seq, $moveData, $goodsData, $exec = ''){
		/* nothing done */
	}
	public function save_move_warehouse() {
		/* nothing done */
	}
	public function chk_remove_stockmove($move_seq){
		/* nothing done */
	}
	public function remove_stockmove($move_seq){
		/* nothing done */
	}
	public function get_sorder_list($sc){
		/* nothing done */
	}
	public function get_sorder_goods($sc){
		/* nothing done */
	}
	public function chk_sorder_param($params){
		/* nothing done */
	}
	public function save_sorder($params, $sorder_seq = ''){
		/* nothing done */
	}
	public function save_sorder_goods($sorder_seq, $goodsData){
		/* nothing done */
	}
	public function copy_sorder($sorder_seq){
		/* nothing done */
	}
	public function complete_sorder($sorder_seq){
		/* nothing done */
	}
	public function save_except_sorder($whs, $goodsData){
		/* nothing done */
	}
	public function get_sorder_draft_info($srarch_sono){
		/* nothing done */
	}
	public function sorder_remove_complete($sorder_seq){
		/* nothing done */
	}
	public function get_latest_sorder($sc){
		/* nothing done */
	}
	public function sorder_cancel($sorder_seq, $mode = 'cancel'){
		/* nothing done */
	}
	public function chk_modify_sorder_param($params){
		/* nothing done */
	}
	public function chg_warehousing_target_sorder($old_sorder_seq, $new_sorder_seq){
		/* nothing done */
	}
	public function get_warehousing_list($sc){
		/* nothing done */
	}
	public function get_warehousing_goods($sc){
		/* nothing done */
	}
	public function chk_warehousing_param($params){
		/* nothing done */
	}
	public function save_warehousing($params, $whs_seq = ''){
		/* nothing done */
	}
	public function save_warehousing_goods($whs, $goodsData, $exec){
		/* nothing done */
	}
	public function get_last_warehousing($sc){
		/* nothing done */
	}
	public function remove_warehousing($whsSeq){
		/* nothing done */
	}
	public function get_latest_warehousing($sc){
		/* nothing done */
	}
	public function get_carryingout_list($sc){
		/* nothing done */
	}
	public function get_carryingout_goods($sc){
		/* nothing done */
	}
	public function chk_carryingout_param($params){
		/* nothing done */
	}
	public function save_carryingout($params, $cro_seq){
		/* nothing done */
	}
	public function save_carryingout_goods($cro_seq, $exec, $goodsData, $cro){
		/* nothing done */
	}
	public function get_carryingout_draft_info($crono_list){
		/* nothing done */
	}
	public function apply_export_wh($wh_seq, $goodsData){
		/* nothing done */
	}
	public function apply_return_wh($wh_seq, $return_code, $goodsData){
		/* nothing done */
	}
	public function auto_warehousing($wh_seq, $params){
		/* nothing done */
	}
	public function save_ledger_detail($params, $prevParams = array(), $ldg_date = ''){
		/* nothing done */
	}
	public function save_ledger_today($wh_seq = '', $goodsData = array(), $absolute_date = ''){
		/* nothing done */
	}
	public function get_ledger_month_cronstatus($year = '', $month = ''){
		/* nothing done */
	}
	public function save_ledger_month_cronstatus($year = '', $month = '', $cron_status = 0){
		/* nothing done */
	}
	public function delete_ledger_month($year = '', $month = ''){
		/* nothing done */
	}
	public function save_ledger_month($year = '', $month = '', $sc = array()){
		/* nothing done */
	}
	public function save_ledger_month_goods($year, $month, $goods){
		/* nothing done */
	}
	public function save_ledger_month_wh_goods($year, $month, $wh_seq, $goods){
		/* nothing done */
	}
	public function get_ledger_month($sc){
		/* nothing done */
	}
	public function get_ledger($sc){
		/* nothing done */
	}
	public function get_ledger_detail($sc){
		/* nothing done */
	}
	public function get_eainfo_to_ledger_detail($sc){
		/* nothing done */
	}
	public function ledger_controllers($page = 'ledger', $pageParam = array()){
		/* nothing done */
	}
	public function get_sorder($sc){
		/* nothing done */
	}
	public function get_sorder_statgoods($sc){
		/* nothing done */
	}
	public function get_sorder_goods_whs($sc){
		/* nothing done */
	}
	public function sorder_forwhs_total($param,$sorder_seq){
		/* nothing done */
	}
	public function get_total_soder($sorder_seq,$sc){
		/* nothing done */
	}
	public function get_inven($sc,$warehouses){
		/* nothing done */
	}
	public function get_traderaccount($sc){
		/* nothing done */
	}
	public function get_traderaccount_list($sc){
		/* nothing done */
	}
	public function get_traderaccount_detail($sc){
		/* nothing done */
	}
	public function save_traderaccount($params, $usesum = 'y'){
		/* nothing done */
	}
	public function calculate_traderaccount($traders = array(), $act_date = ''){
		/* nothing done */
	}

}