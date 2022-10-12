<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/**
 * 즐겨찾기 라이브러리
 *
 * @package		Firstmall
 * @author		WooSuk Choi <cws@gabiacns.com>
 * @copyright	2022 Gabia C&S
 */
class bookmarklibrary
{
	protected $menuList;

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('bookmarkmodel');

		// 관리자/입점사 메뉴 리스트
		$this->loadMenuList();

		// 관리자/입점사 구분하여 파라미터 생성
		if (defined('__ADMIN__') === true && $this->CI->managerInfo) {
			$this->actor = 'manager';
			$this->managerSeq = $this->CI->managerInfo['manager_seq'];
		} elseif (defined('__SELLERADMIN__') === true && $this->CI->providerInfo) {
			$this->actor = 'provider';
			$this->managerSeq = $this->CI->providerInfo['sub_provider_seq'];
		}
	}

	/**
	 * 즐겨찾기 메뉴 추가/삭제
	 * @param array $params
	 */
	public function setBookmark($params)
	{
		// POST 파라미터 vaildation
		if (!$this->_validateBookmarkData($params)) {
			return;
		}

		// 즐겨찾기 메뉴 seq를 체크하여 즐겨찾기 추가/삭제 구분
		if (empty($params['seq'])) {
			// 즐겨찾기 전용 파라미터 세팅
			$data = $this->_getBookmarkParameter($params['code'], $params['link']);

			// 즐겨찾기 메뉴 추가
			$this->CI->bookmarkmodel->insertBookmark($data);
		} else {
			// 즐겨찾기 메뉴 삭제
			$this->CI->bookmarkmodel->deleteBookmark($params['seq']);
		}
	}

	/**
	 * LNB 메뉴 열기/닫기 저장
	 * @param array $params
	 * @return int
	 */
	public function setLnbConf($params)
	{
		// LNB 메뉴 seq를 체크하여 열기/닫기 구분
		if (empty($params['seq'])) {
			// insert용 파라미터 세팅
			$data = $this->_getBookmarkParameter('lnb_close');

			// LNB 메뉴 CLOSE
			$seq = $this->CI->bookmarkmodel->insertBookmark($data);
		} else {
			// LNB 메뉴 OPEN
			$this->CI->bookmarkmodel->deleteBookmark($params['seq']);
		}

		return $seq;
	}

	/**
	 * 즐겨찾기 메뉴 가져오기
	 * @return array
	 */
	public function getBookmark()
	{
		// 현재 접속중인 관리자/입점사 즐겨찾기 메뉴 리스트 가져오기
		$params['actor'] = $this->actor;
		$params['manager_seq'] = $this->managerSeq;
		$data = $this->CI->bookmarkmodel->getBookmarkList($params);

		// 즐겨찾기 메뉴와 관리자/입점사 메뉴 매칭
		$bookmarkMenuList = $this->_matchBookmarkMenu($data);

		return $bookmarkMenuList;
	}

	/**
	 * LNB 메뉴 열기/닫기 여부 가져오기
	 * @return array
	 */
	public function getLnbClose()
	{
		// 현재 접속중인 관리자/입점사 LNB 메뉴 열기/닫기 여부 가져오기
		$params['manager_seq'] = $this->managerSeq;
		$params['actor'] = $this->actor;
		$params['main_menu'] = 'lnb_close';

		return $this->CI->bookmarkmodel->getBookmarkOne($params);
	}

	/**
	 * 관리자/입점사 메뉴 리스트 가져오기
	 */
	protected function loadMenuList()
	{
		if (defined('__SELLERADMIN__') === true) {
			$this->menuList = parse_ini_file(APPPATH . 'config/_provider_menu.ini', true, INI_SCANNER_RAW);
		} else {
			$this->menuList = parse_ini_file(APPPATH . 'config/_pc_menu.ini', true, INI_SCANNER_RAW);
		}
	}

	/**
	 * 즐겨찾기 메뉴 DB 처리 파라미터 세팅 
	 * @param string $main_menu
	 * @param string $bookmark_link
	 * @return array
	 */
	protected function _getBookmarkParameter($main_menu, $bookmark_link = NULL)
	{
		$data['manager_seq'] = $this->managerSeq;
		$data['actor'] = $this->actor;
		$data['main_menu'] = $main_menu;
		$data['bookmark_link'] = $bookmark_link;

		return $data;
	}

	/**
	 * 즐겨찾기 요청 파라미터 Vaildation
	 * @param array $data
	 * @return boolean
	 */
	protected function _validateBookmarkData(&$data)
	{
		// 기본 유효성 검사
		if (empty($data['code']) || empty($data['link'])) {
			return false;
		}

		$allowCode = false;
		$allowLink = false;

		// 즐겨찾기 요청 메뉴가 실제 관리자/입점사 메뉴 내에 있는지 검증
		foreach ($this->menuList as $title => $subMenuList) {
			$titleTmp = explode(':', $title);

			// 대표메뉴 체크
			if ($data['code'] === $titleTmp[0]) {
				$allowCode = true;
			}

			foreach ($subMenuList as $subGroup) {
				$subGroupTmp = explode(':', $subGroup);
				$subGroupLink = explode('|', $subGroupTmp[1]);

				// 서브메뉴 링크 체크
				if ($data['link'] === $subGroupLink[0]) {
					$allowLink = true;
				}

				// 서브메뉴 그룹인지 체크
				if (is_array($subGroup)) {
					foreach ($subGroup as $subData) {
						$subDataTmp = explode(':', $subData);
						$subLink = explode('|', $subDataTmp[1]);

						// 서브메뉴 링크 체크
						if ($data['link'] === $subLink[0]) {
							$allowLink = true;
						}
					}
				}
			}
		}

		// 디자인 편집, HTML 에디터 예외처리
		if (in_array($data['code'], ['designEdit', 'designEditor'])) {
			$allowCode = true;
			$allowLink = true;
		}

		return ($allowCode && $allowLink);
	}

	/**
	 * 관리자 화면 출력용 메뉴 매칭
	 * 관리자/입점사 메뉴 리스트 순서대로 매칭하여 배열생성
	 * fm_bookmark 데이터와 관리자/입점사 메뉴 리스트가 일치해야 함
	 * 
	 * @param array $bookmarkList
	 * @return array
	 */
	protected function _matchBookmarkMenu($bookmarkList)
	{
		// 기본 유효성 검사
		if (empty($bookmarkList)) {
			return $bookmarkList;
		}

		$menuList = [];
		$count = 0;

		// 매칭용 관리자/입점사 메뉴 배열 생성
		foreach ($this->menuList as $title => $subMenuList) {
			$mainMenu = explode(':', $title);

			foreach ($subMenuList as $subGroupTitle => $subGroup) {
				if ($subGroupTitle === 'category') {
					continue;
				}

				// 특수문자 분리
				$subGroupTmp = explode(':', $subGroup);
				$subGroupName = explode(',', $subGroupTmp[0]);
				$subGroupLink = explode('|', $subGroupTmp[1]);

				// 서브메뉴 그룹인지 체크
				if (is_array($subGroup)) {
					foreach ($subGroup as $subData) {
						// 특수문자 분리
						$subDataTmp = explode(':', $subData);
						$subName = explode(',', $subDataTmp[0]);
						$subLink = explode('|', $subDataTmp[1]);

						// 매칭용 배열 추가 (대표메뉴, 메뉴명, 메뉴링크)
						$menuList[$count]['main_menu'] = $mainMenu[0];
						$menuList[$count]['title'] = $subName[0];
						$menuList[$count]['link'] = $subLink[0];

						$count++;

						// 디자인 대표메뉴에 추가 (디자인 편집, HTML 에디터)
						if ($subName[0] == '스킨 추가') {
							$designArr = ['designEdit', 'designEditor'];

							foreach ($designArr as $designData) {
								$menuList[$count]['main_menu'] = $designData;
								$count++;
							}
						}
					}
				} else {
					// 매칭용 배열 추가 (대표메뉴, 메뉴명, 메뉴링크)
					$menuList[$count]['main_menu'] = $mainMenu[0];
					$menuList[$count]['title'] = $subGroupName[0];
					$menuList[$count]['link'] = $subGroupLink[0];

					$count++;
				}
			}
		}

		$bookmarkMenuList = [];
		$count = 0;

		// 즐겨찾기 리스트와 관리자/입점사 메뉴 순서대로 매칭
		foreach ($menuList as $menuData) {
			foreach ($bookmarkList as $boomark) {
				$bookmarkMenuList[$count]['seq'] = $boomark['seq'];

				if ($menuData['link'] === $boomark['bookmark_link']) {
					// 매칭된 즐겨찾기 메뉴 리스트 배열에 담기
					$bookmarkMenuList[$count]['main_menu'] = $menuData['main_menu'];
					$bookmarkMenuList[$count]['title'] = $menuData['title'];
					$bookmarkMenuList[$count]['link'] = $menuData['link'];

					$count++;
				}

				// 디자인 영역에 추가 (디자인 편집, HTML 에디터)
				if ($menuData['main_menu'] === $boomark['main_menu']
					&& in_array($menuData['main_menu'], ['designEdit', 'designEditor'])) {
					$bookmarkMenuList[$count]['main_menu'] = $menuData['main_menu'];
					$count++;
				}
			}
		}

		return $bookmarkMenuList;
	}
}
