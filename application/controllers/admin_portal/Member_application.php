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

class Member_application extends MY_Controller
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
        $this->load->model('admin_portal/member_application_model', 'member_application');
        $this->load->model('system_counter_generator_model', 'system_counter');

        $this->output->set_header("X-Robots-Tag: noindex");
        $this->output->set_header('Cache-Control: no-store, no-cache');
        
        //Check Session
        $this->check_session('adminIn', 'admin/login');
    } //End __construct

    public function get_member_application()
    {
        $request = $this->member_application->get_member_application();
        $data = array();
        $no = $_POST['start'];
        foreach ($request as $list) {
            $no++;
            $row = array();

            $fullname = $list->last_name.', '.$list->first_name;
            $application_id = $this->cipher->encrypt($list->application_id);

            $row[] = $no;
            $row[] = $list->application_no;
            $row[] = ucwords($fullname);
            $row[] = date('D M j, Y h:i A', strtotime($list->date_created));

            $stageColors = array(
                'For Validation' => 'bg-warning',
                'Approved' => 'bg-success',
                'Declined' => 'bg-danger',
            );
            $color = array_key_exists($list->request_status, $stageColors) ? $stageColors[$list->request_status] : 'bg-secondary';
            $row[] = '<div class="badge '.$color.'">'.$list->request_status.'</div>';

            $row[] = '<div class="btn-group">
                        <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                            <li><a target="_blank" href="'.base_url('admin/member-application/information?application=').$application_id.'" class="dropdown-item link-cursor text-primary"><i class="bi bi-view-list me-2"></i>View Request</a></li>
                        </ul>
                    </div>';

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->member_application->count_all(),
            "recordsFiltered" => $this->member_application->count_filtered(),
            "data" => $data,
            "csrf_token_value" => $this->security->get_csrf_hash(),
            "csrf_token_name" => $this->security->get_csrf_token_name(),
        );
        echo json_encode($output);
    }

}