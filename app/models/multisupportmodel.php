<?php
class Multisupportmodel extends CI_Model {

	public function getHscodeInfo($typeCode = false) {

		$hscodeInfo['1']		= '제 1류 살아 있는 동물';
		$hscodeInfo['2']		= '제 2류 육과 식용 설육(屑肉)';
		$hscodeInfo['3']		= '제 3류 어류 / 갑각류 / 연체동물과 그 밖의 수생(水生) 무척추동물';
		$hscodeInfo['4']		= '제 4류 낙농품, 새의 알, 천연꿀, 다른 류로 분류되지 않은 식용인 동물성 생산품';
		$hscodeInfo['5']		= '제 5류 다른 류로 분류되지 않은 동물성 생산품';
		$hscodeInfo['6']		= '제 6류 살아 있는 수목과 그 밖의 식물, 인경(鱗莖) / 뿌리와 이와 유사한 물품, 절화(切花)와 장식용 잎';
		$hscodeInfo['7']		= '제 7류 식용의 채소 / 뿌리 / 괴경(塊莖)';
		$hscodeInfo['8']		= '제 8류 식용의 과실과 견과류, 감귤류 / 멜론의 껍질';
		$hscodeInfo['9']		= '제 9류 커피 / 차 / 마테(maté) / 향신료';
		$hscodeInfo['10']		= '제 10류 곡물';
		$hscodeInfo['11']		= '제 11류 제분공업의 생산품과 맥아, 전분, 이눌린(inulin), 밀의 글루텐(gluten)';
		$hscodeInfo['12']		= '제 12류 채유(採油)에 적합한 종자와 과실, 각종 종자와 과실, 공업용 / 의약용 식물, 짚과 사료용 식물';
		$hscodeInfo['13']		= '제 13류 락(lac), 검 / 수지 / 그 밖의 식물성 수액과 추출물(extract)';
		$hscodeInfo['14']		= '제 14류 식물성 편조물(編組物)용 재료와 다른 류로 분류되지 않은 식물성 생산품';
		$hscodeInfo['15']		= '제 15류 동물성 / 식물성 지방과 기름 및 이들의 분해생산물, 조제한 식용 지방과 동물성 / 식물성 납(蠟)';
		$hscodeInfo['16']		= '제 16류 육류 / 어류 / 갑각류 / 연체동물이나 그 밖의 수생(水生) 무척추동물의 조제품';
		$hscodeInfo['17']		= '제 17류 당류(糖類)와 설탕과자';
		$hscodeInfo['18']		= '제 18류 코코아와 그 조제품';
		$hscodeInfo['19']		= '제 19류 곡물 / 고운 가루 / 전분 / 밀크의 조제품과 베이커리 제품';
		$hscodeInfo['20']		= '제 20류 채소 / 과실 / 견과류나 식물의 그 밖의 부분의 조제품';
		$hscodeInfo['21']		= '제 21류 각종 조제 식료품';
		$hscodeInfo['22']		= '제 22류 음료 / 주류 / 식초';
		$hscodeInfo['23']		= '제 23류 식품 공업에서 생기는 잔재물과 웨이스트(waste), 조제 사료';
		$hscodeInfo['24']		= '제 24류 담배와 제조한 담배 대용물';
		$hscodeInfo['25']		= '제 25류 소금, 황, 토석류(土石類), 석고 / 석회 / 시멘트';
		$hscodeInfo['26']		= '제 26류 광(鑛) / 슬래그(slag) / 회(灰)';
		$hscodeInfo['27']		= '제 27류 광물성 연료 / 광물유(鑛物油)와 이들의 증류물, 역청(瀝靑)물질, 광물성 왁스';
		$hscodeInfo['28']		= '제 28류 무기화학품, 귀금속 / 희토류(稀土類)금속 / 방사성원소 / 동위원소의 유기화합물이나 무기화합물';
		$hscodeInfo['29']		= '제 29류 유기화학품';
		$hscodeInfo['30']		= '제 30류 의료용품';
		$hscodeInfo['31']		= '제 31류 비료';
		$hscodeInfo['32']		= '제 32류 유연용 / 염색용 추출물(extract), 탄닌과 이들의 유도체, 염료 / 안료와 그 밖의 착색제, 페인트 / 바니시(varnish), 퍼티(putty)와 그 밖의 매스틱(mastic), 잉크';
		$hscodeInfo['33']		= '제 33류 정유(essential oil)와 레지노이드(resinoid), 조제향료와 화장품 / 화장용품';
		$hscodeInfo['34']		= '제 34류 비누 / 유기계면활성제 / 조제 세제 / 조제 윤활제 / 인조 왁스 / 조제 왁스 / 광택용이나 연마용 조제품 / 양초와 이와 유사한 물품 / 조형용 페이스트(paste) / 치과용 왁스와 플라스터(plaster)를 기본 재료로 한 치과용 조제품';
		$hscodeInfo['35']		= '제 35류 단백질계 물질, 변성전분, 글루(glue), 효소';
		$hscodeInfo['36']		= '제 36류 화약류, 화공품, 성냥, 발화성 합금, 특정 가연성 조제품';
		$hscodeInfo['37']		= '제 37류 사진용이나 영화용 재료';
		$hscodeInfo['38']		= '제 38류 각종 화학공업 생산품';
		$hscodeInfo['39']		= '제 39류 플라스틱과 그 제품';
		$hscodeInfo['40']		= '제 40류 고무와 그 제품';
		$hscodeInfo['41']		= '제 41류 원피(모피는 제외한다)와 가죽';
		$hscodeInfo['42']		= '제 42류 가죽제품, 마구, 여행용구 / 핸드백과 이와 유사한 용기, 동물 거트(gut)[누에의 거트(gut)는 제외한다]의 제품';
		$hscodeInfo['43']		= '제 43류 모피 / 인조모피와 이들의 제품';
		$hscodeInfo['44']		= '제 44류 목재와 그 제품, 목탄';
		$hscodeInfo['45']		= '제 45류 코르크(cork)와 그 제품';
		$hscodeInfo['46']		= '제 46류 짚 / 에스파르토(esparto)나 그 밖의 조물 재료의 제품, 바구니 세공물(basketware)과 지조세공물(枝條細工物)';
		$hscodeInfo['47']		= '제 47류 목재나 그 밖의 섬유질 셀룰로오스재료의 펄프, 회수한 종이 / 판지[웨이스트(waste)와 스크랩(scrap)]';
		$hscodeInfo['48']		= '제 48류 종이와 판지, 제지용 펄프 / 종이 / 판지의 제품';
		$hscodeInfo['49']		= '제 49류 인쇄서적 / 신문 / 회화 / 그 밖의 인쇄물, 수제(手製)문서 / 타자문서 / 도면';
		$hscodeInfo['50']		= '제 50류 견';
		$hscodeInfo['51']		= '제 51류 양모 / 동물의 부드러운 털이나 거친 털 / 말의 털로 만든 실과 직물';
		$hscodeInfo['52']		= '제 52류 면';
		$hscodeInfo['53']		= '제 53류 그 밖의 식물성 방직용 섬유, 종이실(paper yarn)과 종이실로 만든 직물';
		$hscodeInfo['54']		= '제 54류 인조필라멘트, 인조방직용 섬유재료의 스트립(strip)과 이와 유사한 것';
		$hscodeInfo['55']		= '제 55류 인조스테이플섬유';
		$hscodeInfo['56']		= '제 56류 워딩(wadding) / 펠트(felt) / 부직포, 특수사, 끈 / 배의 밧줄(cordage) / 로프 / 케이블과 이들의 제품';
		$hscodeInfo['57']		= '제 57류 양탄자류와 그 밖의 방직용 섬유로 만든 바닥깔개';
		$hscodeInfo['58']		= '제 58류 특수직물, 터프트(tuft)한 직물, 레이스, 태피스트리(tapestry), 트리밍(trimming), 자수천';
		$hscodeInfo['59']		= '제 59류 침투 / 도포 / 피복하거나 적층한 방직용 섬유의 직물, 공업용인 방직용 섬유제품';
		$hscodeInfo['60']		= '제 60류 메리야스 편물과 뜨개질 편물';
		$hscodeInfo['61']		= '제 61류 의류와 그 부속품(메리야스 편물이나 뜨개질 편물에만 적용한다)';
		$hscodeInfo['62']		= '제 62류 의류와 그 부속품(메리야스 편물이나 뜨개질편물은 제외한다)';
		$hscodeInfo['63']		= '제 63류 제품으로 된 방직용 섬유의 그 밖의 물품, 세트, 사용하던 의류 / 방직용 섬유제품, 넝마';
		$hscodeInfo['64']		= '제 64류 신발류 / 각반과 이와 유사한 것, 이들의 부분품';
		$hscodeInfo['65']		= '제 65류 모자류와 그 부분품';
		$hscodeInfo['66']		= '제 66류 산류(傘類) / 지팡이 / 시트스틱(seat-stick) / 채찍 / 승마용 채찍과 이들의 부분품';
		$hscodeInfo['67']		= '제 67류 조제 깃털 / 솜털과 그 제품, 조화, 사람 머리카락으로 된 제품';
		$hscodeInfo['68']		= '제 68류 돌 / 플라스터(plaster) / 시멘트 / 석면 / 운모나 이와 유사한 재료의 제품';
		$hscodeInfo['69']		= '제 69류 도자제품';
		$hscodeInfo['70']		= '제 70류 유리와 유리제품';
		$hscodeInfo['71']		= '제 71류 천연진주 / 양식진주 / 귀석 / 반귀석 / 귀금속 / 귀금속을 입힌 금속과 이들의 제품, 모조 신변장식용품, 주화';
		$hscodeInfo['72']		= '제 72류 철강';
		$hscodeInfo['73']		= '제 73류 철강의 제품';
		$hscodeInfo['74']		= '제 74류 구리와 그 제품';
		$hscodeInfo['75']		= '제 75류 니켈과 그 제품';
		$hscodeInfo['76']		= '제 76류 알루미늄과 그 제품';
		$hscodeInfo['77']		= '제 77류 유보';
		$hscodeInfo['78']		= '제 78류 납과 그 제품';
		$hscodeInfo['79']		= '제 79류 아연과 그 제품';
		$hscodeInfo['80']		= '제 80류 주석과 그 제품';
		$hscodeInfo['81']		= '제 81류 그 밖의 비금속(卑金屬), 서멧(cermet), 이들의 제품';
		$hscodeInfo['82']		= '제 82류 비금속(卑金屬)으로 만든 공구 / 도구 / 칼붙이 / 스푼 / 포크, 이들의 부분품';
		$hscodeInfo['83']		= '제 83류 비금속(卑金屬)으로 만든 각종 제품';
		$hscodeInfo['84']		= '제 84류 원자로 / 보일러 / 기계류와 이들의 부분품';
		$hscodeInfo['85']		= '제 85류 전기기기와 그 부분품, 녹음기 / 음성 재생기 / 텔레비전의 영상과 음성의 기록기 / 재생기와 이들의 부분품 / 부속품';
		$hscodeInfo['86']		= '제 86류 철도용이나 궤도용 기관차 / 차량과 이들의 부분품, 철도용이나 궤도용 장비품과 그 부분품, 기계식(전기기계식을 포함한다) 각종 교통신호용 기기';
		$hscodeInfo['87']		= '제 87류 철도용이나 궤도용 외의 차량과 그 부분품 / 부속품';
		$hscodeInfo['88']		= '제 88류 항공기와 우주선, 이들의 부분품';
		$hscodeInfo['89']		= '제 89류 선박과 수상 구조물';
		$hscodeInfo['90']		= '제 90류 광학기기 / 사진용 기기 / 영화용 기기 / 측정기기 / 검사기기 / 정밀기기 / 의료용 기기, 이들의 부분품과 부속품';
		$hscodeInfo['91']		= '제 91류 시계와 그 부분품';
		$hscodeInfo['92']		= '제 92류 악기와 그 부분품과 부속품';
		$hscodeInfo['93']		= '제 93류 무기 / 총포탄과 이들의 부분품과 부속품';
		$hscodeInfo['94']		= '제 94류 가구, 침구 / 매트리스 / 매트리스 서포트(mattress support) / 쿠션과 이와 유사한 물품, 다른 류로 분류되지 않은 램프 / 조명기구, 조명용 사인 / 조명용 네임플레이트(name-plate)와 이와 유사한 물품, 조립식 건축물';
		$hscodeInfo['95']		= '제 95류 완구 / 게임용구 / 운동용구와 이들의 부분품과 부속품';
		$hscodeInfo['96']		= '제 96류 잡품';
		$hscodeInfo['97']		= '제 97류 예술품 / 수집품 / 골동품';
		

		if ($typeCode > 0) {
			if (isset($hscodeInfo[$typeCode]))
				return $hscodeInfo[$typeCode];
			else
				return '잘못된 HS CODE';
		} else {
			return $hscodeInfo;
		}

	}

	# 국가 리스트
	function getNationList() {
		
		$sql		= "SELECT * FROM fm_shipping_nation  ORDER BY nation_name ASC";
		$query		= $this->db->query($sql);

		$nationList	= array();
		foreach((array)$query->result_array() AS $row) {
			preg_match('/^([\s\S]+) \(([\S\s]+)\)$/', trim($row['nation_name']), $tmpNationInfo);

			$nationCode			= trim($tmpNationInfo[2]);
			$nationName			= trim($tmpNationInfo[1]);
			$nationKeyTmp		= strtoupper(preg_replace('/[^a-zA-Z\s]/', '', $nationCode));
			$nationKey			= $row['nation_key'];
			
			$nationList[$nationCode]['nationKey']		= $nationKey;
			$nationList[$nationCode]['nationCode']		= $nationCode;
			$nationList[$nationCode]['nationName']		= $nationName;
		}

		return $nationList;


	}

	# HSCODE 저장
	function set_hscode($data) {

		if($data['hscode_seq']){

			$sql					= "select hscode_seq,hscode_common from fm_hscode_info where hscode_seq=?";
			$query					= $this->db->query($sql,$data['hscode_seq']);
			$row					= $query->row_array();
			$hscode_seq				= $row['hscode_seq'];
			$hscode_common			= $row['hscode_common'];
			$data['hscode_common']	= $hscode_common;

			if($hscode_seq){
				$sql = "update
							fm_hscode_info 
						SET
							hscode_name		= ?
						,	hscode_type_cont= ?
						where 
							hscode_seq=?";
				$this->db->query($sql,array($data['hscode_name'],$data['hscode_type_cont'],$hscode_seq));
			}

		}else{

			$sql			= "insert into fm_hscode_info (hscode_common,hscode_name,hscode_type_cont) values(?,?,?)";
			$this->db->query($sql,array($data['hscode_common'],$data['hscode_name'],$data['hscode_type_cont']));
			$hscode_seq		= $this->db->insert_id();
			$hscode_common	= $data['hscode_common'];
		}

		if(count($data['hscode_items']) > 0){

			$this->db->query("delete from fm_hscode_info_item where hscode_seq=?",array($hscode_seq));
			foreach ( $data['hscode_items'] as $row) {

				$tmp['hscode']			= $hscode_common.$row['hscode_nation'];
				$setSeql = "
					INSERT INTO	fm_hscode_info_item SET
						hscode_seq			= '".$hscode_seq."'
					,	hscode				= '".$hscode_common.$row['hscode_nation']."'
					,	hscode_common		= '".$hscode_common."'
					,	nation_key			= '".$row['nation_key']."'
					,	hscode_nation		= '".$row['hscode_nation']."'
					,	export_nation_key	= '".$row['export_nation_key']."'
					,	customs_tax			= '".$row['customs_tax']."'
				";
				debug($setSeql);
				$this->db->query($setSeql);

			}
		}
	}

	function get_common_code($common_code){
		$sql					= "SELECT count(*) cnt FROM fm_hscode_info WHERE hscode_common=?";
		$query					= $this->db->query($sql,$common_code);
		$return					= $query->row_array();

		return $return['cnt'];
	}

	# HS CODE 정보 수정
	function get_hscode_info($hscode_common){

		$sql					= "SELECT * FROM fm_hscode_info WHERE hscode_common=?";
		$query					= $this->db->query($sql,$hscode_common);
		$return					= $query->row_array();

		$sql					= "SELECT 
										info.*,nation.nation_name 
									FROM 
										fm_hscode_info_item as info
										left join fm_shipping_nation as nation on info.nation_key=nation.nation_key
									WHERE
										info.hscode_common=?";
		$query					= $this->db->query($sql,$hscode_common);
		$return['hscode_items'] = $query->result_array();

		
		$hscode_item = array();

		if($return['hscode_items']){
			foreach($return['hscode_items'] as $k=>$item){
				$item['export_nation_key']	= unserialize($item['export_nation_key']);
				$item['customs_tax']		= unserialize($item['customs_tax']);
				$return['hscode_items'][$k]['customs_tax']			= $item['customs_tax'];
				$return['hscode_items'][$k]['export_nation_key']	= $item['export_nation_key'];
				foreach($item['export_nation_key'] as $export_nation){
					$sql	= "SELECT nation_name FROM fm_shipping_nation WHERE nation_key=?";
					$query	= $this->db->query($sql,$export_nation);
					$row	= $query->row_array();
					$return['hscode_items'][$k]['export_nation_name'][]	= $row['nation_name'];
				}

				# 상품상세에서 국가별 hscode 4개까지 보여주기
				if($k < 4){ $hscode_item[] = $item['nation_name'].": ".$item['hscode']."(".$item['customs_tax']."%)"; }
			}
		}

		//$return['hscode_nation_info'] = implode(", ",$hscode_item);

		return $return;

	}

	# 등록된 HS CODE 리스트
	function get_hscode_list($sc){

		$wheres = array();
		if($sc['keyword']){
			if($sc['search_type'] == 'all'){
				$sqlWhereClause[] = "(a.hscode_name like '%".$sc['keyword']."%' or a.hscode_common like '%".$sc['keyword']."%')";
			}elseif($sc['search_type']){
				$sqlWhereClause[] = $sc['search_type']." like '%".$sc['keyword']."%'";
			}
		}

		if(!$sc['perpage']){
			$found_rows = false;
		}else{
			$found_rows = true;
			$limitStr =" LIMIT {$sc['page']}, {$sc['perpage']} ";
		}
		if(!$sc['orderby']) $sc['orderby'] = "a.hscode_seq";
		if(!$sc['sort']) $sc['sort'] = "desc";

		$sql				= array();
		$sql['field']		= "*,(select count(*) from fm_goods where hscode=a.hscode_common and hscode != '') as goods_cnt";
		$sql['table']		= "fm_hscode_info AS a";
		$sql['wheres']		= $sqlWhereClause;
		//$sql['countWheres']	= $countWheres;
		$sql['orderby']		= $sc['orderby']." ".$sc['sort'];
		$sql['limit']		= $limitStr;
		$sc['debug']		= 1;

		$result				= pagingNumbering($sql,$sc,$found_rows);

		if($found_rows){
			return $result;
		}else{
			return $result['record'];
		}

	}

	function getHscode($hscode, $mode  = false) {
		$sql			= "SELECT * FROM fm_hscode_info WHERE hscode = ?";
		$result			= $this->db->query($sql, $hscode);
		preg_match('/^([0-9]{2})([0-9]{2})/', $hscode, $hscodeSplitTmp);

		$hscodeNum		= preg_replace("/^{$hscodeSplitTmp[0]}\.|{$hscodeSplitTmp[0]}/", '', $hscode);

		$hscodeType		= $hscodeSplitTmp[1];
		$hscodeUnit		= $hscodeSplitTmp[2];
		$nationsList	= $this->getNationList();


		$return['hscodeType']			= ($hscodeType > 0) ? "제{$hscodeType}류" : '';
		$return['hscodeTypeCode']		= (int) $hscodeType;
		$return['hscodeTypeText']		= $this->getHscodeInfo($return['hscodeTypeCode']);
		$return['hscodeUnit']			= $hscodeUnit;
		$return['hscodeUnitCode']		= (int) $hscodeUnit;
		$return['hscodeNum']			= $hscodeNum;
		$return['nationList']			= array();

		foreach ((array)$result->result_array() as $row) {
			$hscodeInfo					= $row;
			$hscodeInfo['nation_name']	= $nationsList[$row['nation_key']]['nationName'];
			$hscodeInfo['nation_code']	= $nationsList[$row['nation_key']]['nationCode'];
			
			if ($mode == 'ByNations')
				$return['nationList'][$row['nation_key']]	= $hscodeInfo;
			else
				$return['nationList'][$row['nation_key']]	= $hscodeInfo;
		}
		
		return $return;
	}
}
