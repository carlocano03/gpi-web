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

class Member_information extends MY_Controller
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
        $this->load->model('admin_portal/member_information_model', 'member_information');
        $this->load->model('system_counter_generator_model', 'system_counter');

        $this->output->set_header("X-Robots-Tag: noindex");
        $this->output->set_header('Cache-Control: no-store, no-cache');
        
        //Check Session
        $this->check_session('adminIn', 'admin/login');
    } //End __construct

    public function get_member_list()
    {
        $member = $this->member_information->get_member_list();
        $data = array();
        $no = $_POST['start'];
        foreach ($member as $list) {
            $no++;
            $row = array();

            $fullname = $list->last_name.', '.$list->first_name;
            $member_id = $this->cipher->encrypt($list->member_id);

            $row[] = $no;
            $row[] = $list->member_no;
            $row[] = ucwords($fullname);
            $row[] = $list->email_address;
            $row[] = date('D M j, Y h:i A', strtotime($list->date_created));

            $row[] = '<div class="btn-group">
                        <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                            <li><a target="_blank" href="'.base_url('admin/reseller-account/information?id=').$member_id.'" class="dropdown-item text-primary"><i class="bi bi-view-list me-2"></i>View Details</a></li>
                            <li><a class="dropdown-item text-danger update_modal" 
                                data-id="'.$list->member_id.'"
                            ><i class="bi bi-pencil-square me-2"></i>Update Status</a></li>
                        </ul>
                    </div>';

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->member_information->count_all_member(),
            "recordsFiltered" => $this->member_information->count_filtered_member(),
            "data" => $data,
            "csrf_token_value" => $this->security->get_csrf_hash(),
            "csrf_token_name" => $this->security->get_csrf_token_name(),
        );
        echo json_encode($output);
    }
}