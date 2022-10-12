<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

// 기본 설정
$route['google(:any).html'] = "main/googleToken";
$route['link/(:any)/(:any)'] = "link/index";
$route['default_controller'	] = "main/index";
$route['index'] = "index/main_index";
$route['404_override'		] = '';

// 관리자 페이지 설정
$route['admin'] = "admin/main/main_index";
$route['admin/main'] = "admin/main/main_index";
$route['admin/internal/board/(:any)'] = "admin/internal/board/index/$1";

// 관리자 페이지 설정
$route['selleradmin'] = "selleradmin/main/main_index";
$route['selleradmin/main'] = "selleradmin/main/main_index";

// CRM 페이지 설정
$route['admincrm'] = "admincrm/main/main_index";
$route['admincrm/main'] = "admincrm/main/main_index";

// 비디오 커머스 API
$route['api/broadcast/(:num)/(:any)'] = "api/broadcast/$2";
$route['api/broadcast/(:num)/(:any)/(:any)'] = "api/broadcast/$2";
$route['api/broadcast/(:num)'] = "api/broadcast";

$route['404_override'] = 'errdoc/error_404';

/* End of file routes.php */
/* Location: ./application/config/routes.php */