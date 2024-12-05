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

            if ($list->member_status == 0) {
                $row[] = date('D M j, Y h:i A', strtotime($list->date_created));
                $action = 'Deactivate Member';
                $textColor = 'text-danger';
            } else {
                $row[] = date('D M j, Y h:i A', strtotime($list->date_updated));
                $action = 'Activate Member';
                $textColor = 'text-success';
            }

            
            $row[] = '<div class="btn-group">
                        <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-primary view_details" data-id="'.$list->member_id.'"><i class="bi bi-view-list me-2"></i>View Details</a></li>
                            <li><a class="dropdown-item text-info download_form" data-id="'.$member_id.'"><i class="bi bi-cloud-arrow-down me-2"></i>Download Form</a></li>
                            <li><a class="dropdown-item '.$textColor.' user_activation" 
                                data-id="'.$list->member_id.'"
                                data-email="'.$list->email_address.'"
                                data-name="'.$fullname.'"
                                data-user_id="'.$list->member_user_id.'"
                            ><i class="bi bi-person me-2"></i>'.$action.'</a></li>
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

    public function user_activation()
    {
        $success = '';
        $error = '';

        $member_id = $this->input->post('member_id', true);
        $email_address = $this->input->post('email_address', true);
        $name = $this->input->post('name', true);
        $user_id = $this->input->post('user_id', true);
        $action = $this->input->post('action', true);

        if ($action == 'Deactivate') {
            //Deactivate Member
            $update_member = [
                'member_status' => 1, // Deactivated
                'date_updated' => date('Y-m-d H:i:s'),
            ];
            $result = $this->member_information->user_activation($update_member, $member_id);
            if ($result == TRUE) {
                $update_acct = [
                    'is_active' => 1 //Inactive user
                ];
                $this->member_information->update_user_account($update_acct, $user_id);

                //Send email
                $mail_data = [
                    'name_to' => $name,
                ];

                $this->send_email_html([
                    'mail_to'       => $email_address,
                    'cc'            => [],
                    'subject'       => 'Membership Account [Deactivated]',
                    'template_path' => 'admin_portal/email/deactivated_account',
                    'mail_data'     => $mail_data,
                ]);

                $success = 'Membership account successfully deactivated.';
            } else {
                $error = 'Failed to deactivate the member.';
            }
        } else {
            //Activate Member
            $update_member = [
                'member_status' => 0, // Activated
                'date_updated' => NULL,
            ];
            $result = $this->member_information->user_activation($update_member, $member_id);
            if ($result == TRUE) {
                $update_acct = [
                    'is_active' => 0 //Active user
                ];
                $this->member_information->update_user_account($update_acct, $user_id);

                //Send email
                $mail_data = [
                    'name_to' => $name,
                    'email_address' => $email_address,
                ];

                $this->send_email_html([
                    'mail_to'       => $email_address,
                    'cc'            => [],
                    'subject'       => 'Membership Account [Activated]',
                    'template_path' => 'admin_portal/email/activate_account',
                    'mail_data'     => $mail_data,
                ]);

                $success = 'Membership account successfully activated.';
            } else {
                $error = 'Failed to activate the member.';
            }
        }
        $output = array(
            'error' => $error,
            'success' => $success,
        );
        echo json_encode($output);
    }

    public function print_form()
    {
        require_once 'vendor/autoload.php';
        $member_id = $this->cipher->decrypt($this->input->get('member'));
        $data['pdf_data'] = $this->member_information->get_member_information($member_id);

        $mpdf = new \Mpdf\Mpdf( [ 
            'format' => 'A4-P',
            'margin_right' => 0,
            'margin_left' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0
        ]);

        $mpdf->showImageErrors = true;
        $html = $this->load->view( 'admin_portal/pdf/copy_registration_pdf', $data, true );
        $mpdf->WriteHTML( $html );
        $mpdf->Output();
    }

    public function get_member_info()
    {
        $member_id = $this->input->post('member_id', true);
        $info = $this->member_information->get_member_info($member_id);

        $data = [
            'complete_name'             => ucwords($info->member_name) ?? '',
            'birthday'                  => isset($info->birthday) ? date('F j, Y', strtotime($info->birthday)) : '',
            'birth_place'               => ucwords($info->birth_place),
            'gender'                    => ucfirst($info->gender) ?? '',
            'precinct_no'               => $info->precinct_no ?? '',
            'civil_status'              => ucfirst($info->civil_status) ?? '',
            'spouse_name'               => ucwords($info->spouse_name) ?? '',
            'occupation'                => isset($info->occupation) ? ucwords(str_replace('_', ' ', $info->occupation)) : '',
            'others_occupation'         => ucwords($info->others_occupation) ?? '',
            'retiree'                   => strtoupper($info->retiree) ?? '',
            'phone_no'                  => $info->phone_number ?? '',
            'mobile_no'                 => $info->mobile_number ?? '',
            'email_address'             => $info->email_address ?? '',
            'religion'                  => ucwords($info->religion) ?? '',
            'citizenship'               => ucwords($info->citizenship),
            'province'                  => ucwords($info->province) ?? '',
            'municipality'              => ucwords($info->municipality) ?? '',
            'barangay'                  => ucwords($info->barangay) ?? '',
            'residence_address'         => ucwords($info->residence_address) ?? '',
            'residence_when'            => $info->residence_when ?? '',
            'mother_name'               => ucwords($info->mother_name) ?? '',
            'father_name'               => ucwords($info->father_name) ?? '',

            'em_contact_name'           => ucwords($info->em_contact_name) ?? '',
            'em_relationship'           => ucwords($info->em_relationship) ?? '',
            'em_phone'                  => $info->em_phone_np ?? '',
            'em_mobile'                 => $info->em_mobile_no ?? '',
            'em_address'                => ucwords($info->em_address) ?? '',

            'selfie_attachment'         => $info->selfie_img ?? '',
            'signature_attachment'      => $info->signature ?? '',
            'government_id'             => $info->government_id ?? '',
        ];

        echo json_encode($data);
    }
}