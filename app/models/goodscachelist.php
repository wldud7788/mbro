<?php
class goodscachelist extends CI_Model
{
	protected $table = 'fm_goods_cache_list';

	protected function get_query_delete($check = false){
		$this->db->reset_query();
		$this->db->select('gcl.goods_seq');
		$this->db->from('`fm_goods_cache_list` `gcl` USE INDEX(`PRIMARY`)');
		$this->db->join('fm_goods go', "go.goods_seq = gcl.goods_seq  AND go.goods_type = 'goods' AND go.provider_status = '1' AND go.goods_view = 'look' AND go.goods_status IN('normal', 'runout', 'purchasing', 'unsold')", 'left');
		$this->db->join('fm_goods_list_summary gl', "go.goods_seq = gl.goods_seq AND gl.platform = 'M'", 'left');
		$this->db->where('go.goods_seq', null);
		if ($check) {
			$this->db->limit(1);
		}
		return $this->db->get_compiled_select();
	}

	protected function get_query_category_link_code()
	{
		$this->db->reset_query();
		$this->db->select('GROUP_CONCAT(`category_code`)');
		$this->db->from('fm_category_link');
		$this->db->WHERE('`goods_seq`', '`go`.`goods_seq`', false);
		return $this->db->get_compiled_select();
	}

	protected function get_query_brand_link_code()
	{
		$this->db->reset_query();
		$this->db->select('GROUP_CONCAT(`category_code`)');
		$this->db->from('fm_brand_link');
		$this->db->WHERE('`goods_seq`', '`go`.`goods_seq`', false);
		return $this->db->get_compiled_select();
	}

	protected function get_query_shipping_group()
	{
		$this->db->reset_query();
		$this->db->select('free_gl_shipping');
		$this->db->from('fm_shipping_group_summary');
		$this->db->WHERE('`shipping_group_seq`', '`go`.`shipping_group_seq`', false);
		return str_replace('`free_gl_shipping`', "CONCAT(`free_shipping_use`, ',', `gl_shipping_yn`)", $this->db->get_compiled_select());
	}

	protected function get_cache_data($cacheDate = false, $check = false)
	{
		$db = (clone $this->db)->reset_query();
		if ($check) {
			$db->select('go.goods_seq');
			$db->limit(1);
		} else {
			$sSubCategoryLinkCode = $this->get_query_category_link_code();
			$sSubBrandLinkCode = $this->get_query_brand_link_code();
			$sSubShippingGroup = $this->get_query_shipping_group();
			$db->select('go.goods_seq, go.provider_seq, go.goods_name, go.keyword, go.default_price, go.color_pick, go.purchase_ea, go.purchase_ea_3mon, go.review_count, gl.ranking_point');
			$db->select('(' . $sSubCategoryLinkCode . ') `category_link_code`');
			$db->select('(' . $sSubBrandLinkCode . ') `brand_link_code`');
			$db->select('(' . $sSubShippingGroup . ') `shipping_group`');
		}

		$db->from('fm_goods go');
		$db->join('fm_goods_list_summary gl', "go.goods_seq = gl.goods_seq AND gl.platform = 'M'", 'inner');
		$db->where('go.goods_type', 'goods');
		$db->where('go.provider_status', '1');
		$db->where('go.goods_view', 'look');
		$db->where_in('go.goods_status', array('normal', 'runout', 'purchasing', 'unsold'));
		if ($cacheDate) {
			$db->where('go.update_date >=', $cacheDate);
		}

		return $db;
	}

	public function get_goods($cacheDate)
	{
		return $this->get_cache_data($cacheDate, false);
	}

	public function check_delete_goods($cacheDate)
	{
		return $this->db->query($this->get_query_delete(true));
	}

	public function check_update_goods($cacheDate)
	{
		return $this->get_cache_data($cacheDate, true)->get();
	}

	public function delete_goods_cache()
	{
		$query = $this->get_query_delete();

		$this->db->reset_query();
		$results = $this->db->query($query);
		while ($row = $results->unbuffered_row('array')) {
			$this->db->where('goods_seq', $row['goods_seq'])->delete($this->table);
		}
	}

	public function save(array $data)
	{
		if ($data['category_link_code']) {
			$data['category_link_code'] = ',' . $data['category_link_code'].',';
		}
		if ($data['brand_link_code']) {
			$data['brand_link_code'] = ',' . $data['brand_link_code'].',';
		}
		$aShippingGroup = explode(',', $data['shipping_group']);
		unset($data['shipping_group']);
		$data['free_shipping_use'] = $aShippingGroup[0];
		$data['gl_shipping_yn'] = $aShippingGroup[1];
		$this->db->replace($this->table, $data);
	}

	public function clean()
	{
		$this->db->truncate($this->table);
	}
}
