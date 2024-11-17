<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

//ADMINISTRATOR PORTAL
$route['admin/dashboard'] = 'admin_portal/main/index';
$route['admin/login'] = 'admin_portal/login/index';

$route['admin/member-application'] = 'admin_portal/main/member_application';
$route['admin/active-member'] = 'admin_portal/main/active_member';
$route['admin/inactive-member'] = 'admin_portal/main/inactive_member';
$route['admin/account-management'] = 'admin_portal/main/account_management';
$route['admin/manage-news'] = 'admin_portal/main/manage_news';
$route['admin/manage-news/add-form'] = 'admin_portal/main/news_add_form';
$route['admin/manage-news/view'] = 'admin_portal/main/view_news';

$route['admin/pdf'] = 'admin_portal/main/pdf_file';

//Mobile API Call
//[POST REQUEST]
$route['api/registration-process'] = 'mobile/api_member_registration/process_registration';
$route['api/login-process'] = 'mobile/api_auth_login/login_process';
$route['api/change-password'] = 'mobile/api_auth_login/change_password';
$route['api/save-mpin'] = 'mobile/api_auth_login/save_mpin';
$route['api/login-mpin'] = 'mobile/api_auth_login/login_mpin';
//[GET REQUEST]

$route['default_controller'] = 'main';
$route['404_override'] = 'main/page404';
$route['(:any)'] = 'main/index/$1';
$route['translate_uri_dashes'] = FALSE;