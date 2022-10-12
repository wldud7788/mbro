<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class category_process extends admin_base {

	public function __construct() {
		parent::__construct();
		$this->load->library('validation');

		/* 관리자 권한 체크 : 시작 */
		$auth = $this->authmodel->manager_limit_act('goods_act');
		if(!$auth){
			echo '<script type="text/javascript">';
			echo 'parent.loadingStop();';
			echo 'parent.alert("권한이 없습니다.");';
			echo '</script>';
			exit;
		}
		/* 관리자 권한 체크 : 끝 */
	}

	public function index()
	{
		redirect("/admin/category/catalog");
	}

	public function category_info()
	{

		$this->validation->set_rules('categoryCode', '카테고리','trim|required|max_length[45]|xss_clean');

		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}
		
		$updateData['category_goods_code']	= $this->input->post('category_goods_code');
		$updateData['update_date']			= date('Y-m-d H:i:s');

		$this->db->where('category_code', $this->input->post('categoryCode'));
		$this->db->update('fm_category', $updateData);

		$callback = "parent.document.location.reload();";
		openDialogAlert("카테고리가 저장 되었습니다.",400,140,'parent.parent',$callback);
	}

	public function catalog_design(){

		$this->load->model('categorymodel');
		$this->load->model('goodsdisplay');

		$params 				= $this->input->post();
		$categoryCode 			= $params['categoryCode'];
		$recommend_display_seq 	= $params['recommend_display_seq'];

		/*
		$query = $this->db->query("select * from fm_category where level>0 and category_code = ?",$categoryCode);
		$categoryData = $query->row_array();
		*/

		$params['search_use'] 				= $params['use_search'];
		// CI post로 받아올때 xss 필터에 걸려 모든 스타일을 지워버려서 $_POST로 수정
		$params['top_html'] 				= $params['use_top_html'] == '1' && $params['use_top_html'] ? $_POST['top_html'] : '';
		$params['recommend_display_seq'] 	= $params['use_recommend'] == '1' && $params['recommend_display_seq'] ? $params['recommend_display_seq'] : '';
		$params['list_use'] 				= $params['use_list'];

		$params['top_html']	= (in_array(strtolower($params['top_html']),array("<p>&nbsp;</p>","<p><br></p>"))) ? '' : $params['top_html'];
		adjustEditorImages($params['top_html']);

/*
		$sort_diff = count($_POST['sorts'])-max($_POST['sorts']);
		if($sort_diff>0){
			$sort_diff = (int)$sort_diff;
			$this->db->query("update fm_category_link set sort=sort+{$sort_diff} where category_code = ?",$categoryCode);
		}

		if(count($_POST['category_link_seqs'])==count($_POST['sorts']) && $_POST['category_link_seqs']!=$_POST['sorts']){
			foreach($_POST['category_link_seqs'] as $i=>$category_link_seq){
				//$sort = $_POST['sorts'][$i];
				$this->db->where('category_link_seq',$category_link_seq);
				$this->db->update('fm_category_link',array('sort'=>$i+1));
			}
		}
*/
		/* 추천상품 설정 저장 : 시작 */
		if(!isset($params['use_recommend'])){
			/* 추천상품 사용안함일경우 추천상품디스플레이삭제 */
			$this->db->query("delete from fm_design_display where display_seq=?",$recommend_display_seq);
			$this->db->query("delete from fm_design_display_tab where display_seq=?",$recommend_display_seq);
			$this->db->query("delete from fm_design_display_tab_item where display_seq=?",$recommend_display_seq);
		}
		/* 추천상품 설정 저장 : 끝 */


		$params['update_date'] = date('Y-m-d H:i:s');

		$data = filter_keys($params, $this->db->list_fields('fm_category'));

		$this->db->update('fm_category', $data, "category_code = {$categoryCode}");
		debug($this->db->last_query());
		/* 카테고리 상품 리스트 저장 : 끝 */

		$callback = "parent.document.location.reload();";
		openDialogAlert("카테고리가 저장 되었습니다.",400,140,'parent.parent',$callback);
	}

	/* 하위카테고리 동일 적용 버튼 */
	public function childset_category_save(){
		$this->load->model('categorymodel');
		$this->categorymodel->childset_category($_GET['div'],$_GET['category_code']);
		$callback = "";
		openDialogAlert("하위 카테고리에 동일하게 세팅 되었습니다.",400,140,'parent.parent',"");
	}

	/* 카테고리 한꺼번에 꾸미기 */
	public function batch_design_setting(){
		$this->load->model('categorymodel');
		$this->load->helper('design');

		$params = $_POST;

		switch($params['mode']){
			case "navigation":
				/* 쇼핑몰(최상위) 카테고리에 적용 */
				skin_configuration_save($this->designWorkingSkin,"category_navigation_type",$_POST['navigation_depth']);
				skin_configuration_save($this->designWorkingSkin,"category_navigation_count_w",implode("|",$_POST["navigation_{$_POST['navigation_depth']}_w"]));
				skin_configuration_save($this->designWorkingSkin,"category_navigation_brand_count_w",$_POST["naviation_category_brand_w"]);

				$callback = "";
				openDialogAlert("세팅된 카테고리 네비게이션 영역이 전체카테고리에 적용되었습니다.",500,140,'parent.parent',"");
			break;
			case "design":
				/* 쇼핑몰(최상위) 카테고리에 적용 */
				adjustEditorImages($params['top_html']);
				$data['top_html'] = $params['top_html'];
				$data['update_date'] = date('Y-m-d H:i:s');
				$data = filter_keys($data, $this->db->list_fields('fm_category'));
				$this->db->where("level >",0);
				$this->db->where("ifnull(category_code,'')","");
				$this->db->update('fm_category', $data);

				/* 하위카테고리에 동일하게 적용 */
				$this->categorymodel->childset_category('top_html','');

				$callback = "";
				openDialogAlert("세팅된 카테고리 디자인 영역이 전체카테고리에 적용되었습니다.",500,140,'parent.parent',"");
			break;
			case "recommend":
				$recommend_display_seq_arr			= $this->categorymodel->set_category_recommend('',$params);
				$data['recommend_display_seq']		= $recommend_display_seq_arr['recommend_display_seq'];
				$data['m_recommend_display_seq']	= $recommend_display_seq_arr['m_recommend_display_seq'];
				$data['update_date']				= date('Y-m-d H:i:s');
				$data								= filter_keys($data, $this->db->list_fields('fm_category'));
				$this->db->where("level >",0);
				$this->db->where("ifnull(category_code,'')","");
				$this->db->update('fm_category', $data);

				/* 하위카테고리에 동일하게 적용 */
				$this->categorymodel->childset_category('recommend','');

				$callback = "";
				openDialogAlert("세팅된 카테고리 추천상품 영역이 전체카테고리에 적용되었습니다.",500,140,'parent.parent',"");
			break;
			case "category":
				$list_image_decorations = isset($params['list_image_decoration']) ? $params['list_image_decoration'] : array();
				if(isset($list_image_decorations)){
					$params['list_image_decorations'] = $list_image_decorations;
				}

				$m_list_image_decorations = isset($params['m_list_image_decoration']) ? $params['m_list_image_decoration'] : array();
				if(isset($m_list_image_decorations)){
					$params['m_list_image_decorations'] = $m_list_image_decorations;
				}

				$list_info_setting = isset($params['list_info_setting']) ? $params['list_info_setting'] : array();
				if(isset($list_info_setting)){
					$params['list_info_settings'] = "[".implode(",",$list_info_setting)."]";
				}

				$m_list_info_setting = isset($params['m_list_info_setting']) ? $params['m_list_info_setting'] : array();
				if(isset($m_list_info_setting)){
					$params['m_list_info_settings'] = "[".implode(",",$m_list_info_setting)."]";
				}

				/* 카테고리 상품 상태설정값 */
				$params['list_goods_status'] = implode("|",$params['list_goods_status']);
				$params['m_list_goods_status'] = implode("|",$params['m_list_goods_status']);

				$params['update_date'] = date('Y-m-d H:i:s');
				$data = filter_keys($params, $this->db->list_fields('fm_category'));

				if(!isset($data['m_list_use'])) $data['m_list_use'] = 'n';

				$this->db->where("level >",0);
				$this->db->where("ifnull(category_code,'')","");
				$this->db->update('fm_category', $data);

				/* 하위카테고리에 동일하게 적용 */
				$this->categorymodel->childset_category('category','');

				$callback = "";
				openDialogAlert("세팅된 카테고리 상품 영역이 전체카테고리에 적용되었습니다.",500,140,'parent.parent',"");
			break;
		}

	}

	public function chgCategorySort(){

		$this->load->model('categorymodel');

		$params			= $_GET;
		$acttype		= $params['acttype'];
		$categoryCode	= $params['categoryCode'];
		$target			= $params['target'];
		$target_cnt		= count($target);
		$seq			= $params['seq'];
		$bsort			= $params['bsort'];
		$asort			= $params['asort'];

		// 정렬이 비정상일 경우 선 재정렬
/*
		if ($this->categorymodel->chkDupleSort($categoryCode)){
			$this->categorymodel->reSortAll($categoryCode);
		}
*/
		switch($acttype){
			case 'resetAll':
				$this->categorymodel->reSortAll($categoryCode);
			break;
			case 'gotop':
				$minsort	= $this->categorymodel->getSortValue($categoryCode, 'min');
				$sort		= $minsort;
				$this->categorymodel->rangeUpdateSort($categoryCode, null, $target[0]['sortval'], '+'.$target_cnt);
				for ($t = 0; $t < $target_cnt; $t++){
					if	($target[$t]['seq'] && !is_null($target[$t]['sortval'])){
						$this->categorymodel->chgCategorySort($target[$t]['seq'], $sort);
						$sort++;
					}
				}
			break;
			case 'gobottom':
				$maxsort	= $this->categorymodel->getSortValue($categoryCode, 'max');
				$sort		= $maxsort - $target_cnt;
				if	($sort < 0){
					$maxsort	= $this->categorymodel->getSortValue($categoryCode, 'cnt');
					$sort		= $maxsort - $target_cnt;
				}
				$this->categorymodel->rangeUpdateSort($categoryCode, $target[($target_cnt-1)]['sortval'], null, '-'.$target_cnt);
				for ($t = 0; $t < $target_cnt; $t++){
					if	($target[$t]['seq'] && !is_null($target[$t]['sortval'])){
						$sort++;
						$this->categorymodel->chgCategorySort($target[$t]['seq'], $sort);
					}
				}
			break;
			case 'goprev1':
				$minsort	= $this->categorymodel->getSortValue($categoryCode, 'min');
				$sort		= $target[0]['sortval'] - 1;
				if	($minsort > $sort)	$sort	= $minsort;
				$this->categorymodel->rangeUpdateSort($categoryCode, $sort-1, $target[0]['sortval'], '+'.$target_cnt);
				for ($t = 0; $t < $target_cnt; $t++){
					if	($target[$t]['seq'] && !is_null($target[$t]['sortval'])){
						$this->categorymodel->chgCategorySort($target[$t]['seq'], $sort);
						$sort++;
					}
				}
			break;
			case 'gonext1':
				$sort	= $target[0]['sortval'] + 1;
				$this->categorymodel->rangeUpdateSort($categoryCode, $target[($target_cnt-1)]['sortval'], $target[($target_cnt-1)]['sortval'] + 2, '-'.$target_cnt);
				for ($t = 0; $t < $target_cnt; $t++){
					if	($target[$t]['seq'] && !is_null($target[$t]['sortval'])){
						$this->categorymodel->chgCategorySort($target[$t]['seq'], $sort);
						$sort++;
					}
				}
			break;
			case 'goprev10':
				$minsort	= $this->categorymodel->getSortValue($categoryCode, 'min');
				$sort	= $target[0]['sortval'] - 10;
				if	($minsort > $sort)	$sort	= $minsort;
				$this->categorymodel->rangeUpdateSort($categoryCode, $sort-1, $target[0]['sortval'], '+'.$target_cnt);
				for ($t = 0; $t < $target_cnt; $t++){
					if	($target[$t]['seq']){
						$this->categorymodel->chgCategorySort($target[$t]['seq'], $sort);
						$sort++;
					}
				}
			break;
			case 'gonext10':
				$sort		= $target[0]['sortval'] + 10;
				$this->categorymodel->rangeUpdateSort($categoryCode, $target[($target_cnt-1)]['sortval'], $sort + 1, '-'.$target_cnt);
				for ($t = 0; $t < $target_cnt; $t++){
					if	($target[$t]['seq'] && !is_null($target[$t]['sortval'])){
						$this->categorymodel->chgCategorySort($target[$t]['seq'], $sort);
					}
				}
			break;
			case 'gomove':
				$bsort	= (($params['page'] * $params['perpage']) - $params['perpage']) + $bsort;
				$asort	= (($params['page'] * $params['perpage']) - $params['perpage']) + $asort;

				if	($seq){
					if	($bsort < $asort){
						$this->categorymodel->rangeUpdateSort($categoryCode, $bsort, $asort+1, '-1');
						$this->categorymodel->chgCategorySort($seq, $asort);
					}elseif	($bsort > $asort){
						$this->categorymodel->rangeUpdateSort($categoryCode, $asort-1, $bsort, '+1');
						$this->categorymodel->chgCategorySort($seq, $asort);
					}
				}
			break;
		}

		echo $params['page'];
	}
}

/* End of file category.php */
/* Location: ./app/controllers/admin/category.php */