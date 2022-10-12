<?php

/**
 *
 */

class goodscachefilter extends CI_Model
{
	protected $bGoodsSearchCache = false;
    protected $table = 'fm_goods_cache_filter';

	public function __construct()
	{
		parent::__construct();

		if ($this->config_system['goodsSearchCacheUse'] == 'Y') {
			$this->bGoodsSearchCache = true;
		}
	}

    public function save(array $data)
    {
        $search_mode = $data['search_mode'] ?? '';
        $search_code = $data['search_code'] ?? '';
        $filter_type = $data['filter_type'] ?? '';
        $category_code = $data['category_code'] ?? null;

        // 검색 조건
        if (! in_array($search_mode, ['catalog', 'brand'])) {
            return false;
        }

        // 검색 코드
        if (! $search_code) {
            return false;
        }

        // 검색 항목
        if (! in_array($filter_type, ['goods_count', 'max_price', 'category', 'category_child', 'brand', 'provider', 'color'])) {
            return false;
        }

        //
        $data['update_date'] = $data['update_date'] ?: date('Y-m-d H:i:s');

        //
        $query = $this->db->from($this->table)
            ->where('search_mode', $search_mode)
            ->where('search_code', $search_code)
            ->where('filter_type', $filter_type)
            ->where('category_code', $category_code)
            ->get();
        $row = $query->row_array();

        if ($row) {
            $this->db->update($this->table, $data, ['seq' => $row['seq']]);
            return $this->db->affected_rows();
        } else {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        }
    }

    public function get($search_mode, $search_code, $filter_type, $category_code = null)
    {
		if (! $this->bGoodsSearchCache) {
			return false;
		}

        $query = $this->db->from($this->table)
            ->where('search_mode', $search_mode)
            ->where('search_code', $search_code)
            ->where('filter_type', $filter_type)
            ->where('category_code', $category_code)
            ->get();
        if ($row = $query->row_array()) {
            return json_decode($row['json_data'], true);
        } else {
            return false;
        }


    }

    public function delete_by_update_date($update_date)
    {
        $this->db->delete($this->table, ['update_date <' => $update_date]);
    }

    public function clean()
    {
        $this->db->truncate($this->table);
    }

    public function getBrandChildCategory($brand_code, $category_code)
    {
		if (! $this->bGoodsSearchCache) {
			return false;
		}

        $response = [];

        //
        $category_length = strlen($category_code) + 4;

        //
        $selectedFields = [
            'fsfc.search_code category_code',
            'fc.title category_name',
            'fsfc.json_data',
        ];
        $query = $this->db->select($selectedFields)
            ->from($this->table . ' fsfc')
            ->join('fm_category fc', 'fc.category_code = fsfc.search_code', 'inner')
            ->where('fsfc.search_mode', 'catalog')
            ->like('fsfc.search_code', $category_code, 'after')
            ->where('LENGTH(`fsfc`.`search_code`) =', $category_length, null, false)
            ->where('fsfc.filter_type', 'brand')
            ->like('fsfc.json_data', '"brand_code":"' . $brand_code . '"', 'both')
            ->get();

        //
        $results = $query->result_array();

        if (! $results && $category_code) {
            $parent_category_code = substr($category_code, 0, -4);
            return $this->getBrandChildCategory($brand_code, $parent_category_code);
        }

        //
        foreach ($results as $row) {
            $data = [
                'category_code' => $row['category_code'],
                'category_name' => $row['category_name'],
                'cnt' => 0,
            ];

            //
            $json_data = json_decode($row['json_data'], true);
            foreach ($json_data as $brand) {
                if ($brand_code == $brand['brand_code']) {
                    $data['cnt'] = $brand['cnt'];
                    break;
                }
            }

            array_push($response, $data);
        }

        //
        return $response ?: false;
    }

    public function getBrandGoodsCount($brand_code, $category_code)
    {
		if (! $this->bGoodsSearchCache) {
			return false;
		}

        $goods_count = 0;

        //
        $query = $this->db->from($this->table)
            ->where('search_mode', 'catalog')
            ->where('search_code', $category_code)
            ->where('filter_type', 'brand')
            ->like('json_data', '"brand_code":"' . $brand_code . '"', 'both')
            ->get();
        $row = $query->row_array();

        if ($row) {
            $json_data = json_decode($row['json_data'], true);
            foreach ($json_data as $brand) {
                if ($brand_code == $brand['brand_code']) {
                    $goods_count = $brand['cnt'];
                    break;
                }
            }
        } else {
            $goods_count = false;
        }

        //
        return $goods_count;
    }
}
