<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 *
 * @version 1.0
 * @author Carlo Cano <carlocano03@gmail.com>
 * @copyright Copyright &copy; 2023,
 *
 */

class Main extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->helper('language');
        $this->load->library('cipher');
        $this->lang->load('common','english');
        $this->load->model('admin_portal/main_model');

        $this->output->set_header("X-Robots-Tag: noindex");
        $this->output->set_header('Cache-Control: no-store, no-cache');
        
        //Check Session
        $this->check_session('adminIn', 'admin/login');
    } //End __construct

    public function index()
    {
        $data['role_permissions'] = $this->role_permissions();
        $data['home_url'] = base_url('admin/dashboard');
        $data['active_page'] = 'dashboard_page';
        $data['card_title'] = 'Dashboard';
        $data['icon'] = 'bi bi-speedometer2';
        $data['header_contents'] = array(
            '<link href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css" rel="stylesheet">',
            '<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>',
            '<script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap4.min.js"></script>',
            '<script>
                var csrf_token_name = "'.$this->security->get_csrf_token_name().'";
                var csrf_token_value = "'.$this->security->get_csrf_hash().'";
            </script>'
        );
	
        $this->load->view('admin_portal/partial/_header', $data);
        $this->load->view('admin_portal/dashboard', $data);
        $this->load->view('admin_portal/partial/_footer', $data);
    }

    public function member_application()
    {
        $data['member_type'] = $this->main_model->get_user_type();
        $data['role_permissions'] = $this->role_permissions();
        $data['home_url'] = base_url('admin/dashboard');
        $data['active_page'] = 'application_page';
        $data['card_title'] = 'GPI Member Application';
        $data['icon'] = 'bi bi-speedometer2';
        $data['header_contents'] = array(
            '<link href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css" rel="stylesheet">',
            '<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>',
            '<script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap4.min.js"></script>',
            '<script>
                var csrf_token_name = "'.$this->security->get_csrf_token_name().'";
                var csrf_token_value = "'.$this->security->get_csrf_hash().'";
            </script>'
        );
	
        $this->load->view('admin_portal/partial/_header', $data);
        $this->load->view('admin_portal/member_application', $data);
        $this->load->view('admin_portal/partial/_footer', $data);
    }

    public function active_member()
    {
        $data['role_permissions'] = $this->role_permissions();
        $data['home_url'] = base_url('admin/dashboard');
        $data['active_page'] = 'active_member_page';
        $data['card_title'] = 'Active GPI Member';
        $data['icon'] = 'bi bi-speedometer2';
        $data['header_contents'] = array(
            '<link href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css" rel="stylesheet">',
            '<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>',
            '<script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap4.min.js"></script>',
            '<script>
                var csrf_token_name = "'.$this->security->get_csrf_token_name().'";
                var csrf_token_value = "'.$this->security->get_csrf_hash().'";
            </script>'
        );
	
        $this->load->view('admin_portal/partial/_header', $data);
        $this->load->view('admin_portal/active_member', $data);
        $this->load->view('admin_portal/partial/_footer', $data);
    }

    public function update_member_form()
    {
        $member_id = $this->cipher->decrypt($this->input->get('member', true));
        $data['role_permissions'] = $this->role_permissions();
        $data['occupation'] = $this->main_model->get_result('occupation', array('status' => 0));
        $data['religion'] = $this->main_model->get_result('religion', array('status' => 0));
        $data['citizenship'] = $this->main_model->get_result('country', array('status' => 0));
        $data['province'] = $this->main_model->get_result('psgc_province', [], ['name' => 'ASC']);

        $data['info'] = $this->main_model->get_row('member_info', array('member_id' => $member_id));

        $data['home_url'] = base_url('admin/dashboard');
        $data['active_page'] = 'active_member_page';
        $data['card_title'] = 'Update GPI Member Information';
        $data['icon'] = 'bi bi-speedometer2';
        $data['header_contents'] = array(
            '<link href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css" rel="stylesheet">',
            '<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>',
            '<script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap4.min.js"></script>',
            '<script>
                var csrf_token_name = "'.$this->security->get_csrf_token_name().'";
                var csrf_token_value = "'.$this->security->get_csrf_hash().'";
            </script>'
        );
	
        $this->load->view('admin_portal/partial/_header', $data);
        $this->load->view('admin_portal/update_member_form', $data);
        $this->load->view('admin_portal/partial/_footer', $data);
    }

    public function inactive_member()
    {
        $data['role_permissions'] = $this->role_permissions();
        $data['home_url'] = base_url('admin/dashboard');
        $data['active_page'] = 'inactive_member_page';
        $data['card_title'] = 'Inactive GPI Member';
        $data['icon'] = 'bi bi-speedometer2';
        $data['header_contents'] = array(
            '<link href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css" rel="stylesheet">',
            '<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>',
            '<script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap4.min.js"></script>',
            '<script>
                var csrf_token_name = "'.$this->security->get_csrf_token_name().'";
                var csrf_token_value = "'.$this->security->get_csrf_hash().'";
            </script>'
        );
	
        $this->load->view('admin_portal/partial/_header', $data);
        $this->load->view('admin_portal/inactive_member', $data);
        $this->load->view('admin_portal/partial/_footer', $data);
    }

    public function account_management()
    {
        $data['role_permissions'] = $this->role_permissions();
        $data['home_url'] = base_url('admin/dashboard');
        $data['active_page'] = 'account_management_page';
        $data['card_title'] = 'Admin Staff Account';
        $data['icon'] = 'bi bi-speedometer2';
        $data['header_contents'] = array(
            '<link href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css" rel="stylesheet">',
            '<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>',
            '<script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap4.min.js"></script>',
            '<script>
                var csrf_token_name = "'.$this->security->get_csrf_token_name().'";
                var csrf_token_value = "'.$this->security->get_csrf_hash().'";
            </script>'
        );
	
        $this->load->view('admin_portal/partial/_header', $data);
        $this->load->view('admin_portal/admin_account_management', $data);
        $this->load->view('admin_portal/partial/_footer', $data);
    }

    public function manage_news()
    {
        $data['role_permissions'] = $this->role_permissions();
        $data['home_url'] = base_url('admin/dashboard');
        $data['active_page'] = 'manage_news_page';
        $data['card_title'] = 'Manage News';
        $data['icon'] = 'bi bi-newspaper';
        $data['header_contents'] = array(
            '<link href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css" rel="stylesheet">',
            '<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>',
            '<script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap4.min.js"></script>',
            '<script>
                var csrf_token_name = "'.$this->security->get_csrf_token_name().'";
                var csrf_token_value = "'.$this->security->get_csrf_hash().'";
            </script>'
        );
	
        $this->load->view('admin_portal/partial/_header', $data);
        $this->load->view('admin_portal/manage_news', $data);
        $this->load->view('admin_portal/partial/_footer', $data);
    }

    public function news_add_form()
    {
        $data['role_permissions'] = $this->role_permissions();
        $data['home_url'] = base_url('admin/dashboard');
        $data['active_page'] = 'manage_news_page';
        $data['card_title'] = 'Manage News (Add Form)';
        $data['icon'] = 'bi bi-newspaper';
        $data['header_contents'] = array(
            '<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">',
            '<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>',
            '<script>
                var csrf_token_name = "'.$this->security->get_csrf_token_name().'";
                var csrf_token_value = "'.$this->security->get_csrf_hash().'";
            </script>'
        );
	
        $this->load->view('admin_portal/partial/_header', $data);
        $this->load->view('admin_portal/add_news_form', $data);
        $this->load->view('admin_portal/partial/_footer', $data);
    }

    public function view_news()
    {
        $this->load->model('admin_portal/news_management_model');
        $news_id = $this->cipher->decrypt($this->input->get('id'));
        
        $data['news'] = $this->news_management_model->get_row('news', array('news_id' => $news_id, 'status' => 0));
        $data['posted_by'] = $this->news_management_model->get_row('admin_user_details', array('user_id' => $data['news']['user_id']));
        $data['role_permissions'] = $this->role_permissions();
        $data['home_url'] = base_url('admin/dashboard');
        $data['active_page'] = 'manage_news_page';
        $data['card_title'] = 'News Information';
        $data['icon'] = 'bi bi-newspaper';
        $data['header_contents'] = array(
            '<script>
                var csrf_token_name = "'.$this->security->get_csrf_token_name().'";
                var csrf_token_value = "'.$this->security->get_csrf_hash().'";
            </script>'
        );
	
        $this->load->view('admin_portal/partial/_header', $data);
        $this->load->view('admin_portal/view_news', $data);
        $this->load->view('admin_portal/partial/_footer', $data);
    }

    public function getDashboardCount() 
    {
        $total_member = $this->main_model->get_total_member();
        $active_member = $this->main_model->get_member_count(0);
        $inactive_member = $this->main_model->get_member_count(1);
        $pending_application = $this->main_model->get_pending_application();

        $output = [
            'total_member' => number_format($total_member),
            'active_member' => number_format($active_member),
            'inactive_member' => number_format($inactive_member),
            'pending_application' => number_format($pending_application),
        ];

        echo json_encode($output);
    }

    public function get_sidebar_count()
    {
        $pending_application = $this->main_model->get_pending_application();

        $application_request = $pending_application;

        $output = array(
            'application_request' => $application_request,
            'member_request' => $pending_application,
        );

        echo json_encode($output);
    }

    public function check_old_pass()
    {
        $success = '';
        $error = '';
        $old_pass = $this->input->post('old_pass', true);

        $checkPass = $this->main_model->check_old_pass($old_pass);
        if ($checkPass) {
            $success == 'Success';
        } else {
            $error = 'Please input the correct password';
        }
        $output = array(
            'success' => $success,
            'error' => $error,
        );
        echo json_encode($output);
    }

    public function update_password()
    {
        $message = '';
        $new_password = $this->input->post('password', true);

        $update_password = array(
            'password' => password_hash($new_password, PASSWORD_DEFAULT),
            'temp_password' => '',
        );
        $result = $this->main_model->update_password($update_password);
        if ($result == TRUE) {
            $message = 'Success';
        } else {
            $message = 'Error';
        }
        $output['message'] = $message;
        echo json_encode($output);
    }

    public function pdf_file()
    {
        require_once 'vendor/autoload.php';

        $mpdf = new \Mpdf\Mpdf( [ 
            'format' => 'A4-P',
            'margin_right' => 0,
            'margin_left' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0
        ]);

        $mpdf->showImageErrors = true;
        $html = $this->load->view( 'admin_portal/pdf/copy_registration_pdf', [], true );
        $mpdf->WriteHTML( $html );
        $mpdf->Output();
    }

    // public function send_mail()
    // {
    //     //Send email
	// 	$mail_data = [
	// 		'name_to' => 'Carlo Cano',
	// 	];

    //     $pdf_data = [
    //         'sample' => 'Test',
    //     ];

	// 	$this->send_email_attachment([
	// 		'mail_to'       => 'carlocano03@gmail.com',
	// 		'cc'            => [],
	// 		'subject'       => 'Member Application [For Approval]',
	// 		'template_path' => 'admin_portal/email/success_registration',
	// 		'mail_data'     => $mail_data,
    //         'pdf_data'      => $pdf_data,
    //         'application_no' => '1235456',
	// 	]);
    // }

}