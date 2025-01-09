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
$route['/'] = 'main/index';

$route['admin/dashboard'] = 'admin_portal/main/index';
$route['admin/login'] = 'admin_portal/login/index';

$route['admin/member-application'] = 'admin_portal/main/member_application';
$route['admin/active-member'] = 'admin_portal/main/active_member';
$route['admin/active-member/update-information'] = 'admin_portal/main/update_member_form';
$route['admin/inactive-member'] = 'admin_portal/main/inactive_member';
$route['admin/account-management'] = 'admin_portal/main/account_management';
$route['admin/manage-news'] = 'admin_portal/main/manage_news';
$route['admin/manage-news/add-form'] = 'admin_portal/main/news_add_form';
$route['admin/manage-news/view'] = 'admin_portal/main/view_news';

$route['admin/member-information/print_form'] = 'admin_portal/member_information/print_form';
$route['admin/pdf'] = 'admin_portal/main/pdf_file';



//Mobile API Call
//[POST REQUEST]
$route['api/registration-process'] = 'mobile/api_member_registration/process_registration';
$route['api/login-process'] = 'mobile/api_auth_login/login_process';
$route['api/change-password'] = 'mobile/api_auth_login/change_password';
$route['api/save-mpin'] = 'mobile/api_auth_login/save_mpin';
$route['api/login-mpin'] = 'mobile/api_auth_login/login_mpin';

//News Update
$route['api/post-news'] = 'mobile/api_news_update/add_news';
$route['api/comment'] = 'mobile/api_news_update/add_comment';
$route['api/posted-news'] = 'mobile/api_news_update/posted_news';
$route['api/comment-list'] = 'mobile/api_news_update/list_comment';
$route['api/delete-news'] = 'mobile/api_news_update/delete_news';
$route['api/delete-comment'] = 'mobile/api_news_update/delete_comment';

$route['api/create-petition'] = 'mobile/api_petition/create_petition';
$route['api/petition-list'] = 'mobile/api_petition/petition_list';
$route['api/delete-petition'] = 'mobile/api_petition/delete_petition';
$route['api/view-petition'] = 'mobile/api_petition/view_petition';

//Board Member
$route['api/petition-approval-list'] = 'mobile/api_petition/petition_list_approval';
$route['api/view-petition-approval'] = 'mobile/api_petition/view_petition_approval';
$route['api/petition-approval-process'] = 'mobile/api_petition/petition_approval';

//Member Side
$route['api/barangay-petition'] = 'mobile/api_petition/brgy_petition';
$route['api/view-petition-barangay'] = 'mobile/api_petition/view_petition_barangay';
$route['api/signature-process'] = 'mobile/api_petition/signature_process';

$route['api/municipality'] = 'mobile/api_member_registration/municipality';
$route['api/barangay'] = 'mobile/api_member_registration/barangay';

//[GET REQUEST]
$route['api/religion'] = 'mobile/api_member_registration/religion';
$route['api/occupation'] = 'mobile/api_member_registration/occupation';
$route['api/province'] = 'mobile/api_member_registration/province';

$route['default_controller'] = 'main';
$route['404_override'] = 'main/page404';
$route['(:any)'] = 'main/index/$1';
$route['translate_uri_dashes'] = FALSE;