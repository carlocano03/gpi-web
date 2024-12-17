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
    private $counter_member = MEMBER;
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
                            <li><a class="dropdown-item link-cursor text-primary view_details" data-id="'.$list->application_id.'"><i class="bi bi-view-list me-2"></i>View Request</a></li>
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

    public function applicationChart()
    {
        $range = $this->input->get('range');
        $data = $this->member_application->applicationChart($range);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    
    public function get_member_info()
    {
        $application_id = $this->input->post('application_id', true);
        $info = $this->member_application->get_member_info($application_id);

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

    public function download_passport()
    {
        $this->load->helper('download');
        $filename = $this->input->get('file');
        $file_path = 'assets/uploaded_file/member_application/passport/' . $filename;
        force_download($file_path, NULL);
    }

    public function download_selfie()
    {
        $this->load->helper('download');
        $filename = $this->input->get('file');
        $file_path = 'assets/uploaded_file/member_application/selfie_img/' . $filename;
        force_download($file_path, NULL);
    }

    public function download_signature()
    {
        $this->load->helper('download');
        $filename = $this->input->get('file');
        $file_path = 'assets/uploaded_file/member_application/signature/' . $filename;
        force_download($file_path, NULL);
    }

    public function government_id()
    {
        $this->load->helper('download');
        $filename = $this->input->get('file');
        $file_path = 'assets/uploaded_file/member_application/government_id/' . $filename;
        force_download($file_path, NULL);
    }

    public function request_approval()
    {
        $success = '';
        $error = '';
        $application_id = $this->input->post('application_id', true);
        $action = $this->input->post('action', true);

        $request = $this->member_application->get_row('application_request', array('application_id' => $application_id));

        if ($action == 'Approved') {
            //Approved Request
            $check_member = $this->member_application->check_existing_member($request['first_name'], $request['last_name'], $request['birthday']);
            if ($check_member->num_rows() > 0) {
                $error = 'GPI member already exist';
            } else {
                //Insert scholar member
                $member_no = $this->system_counter->get_ctrl_num_cv($this->counter_member);

                $insert_member = array(
                    'member_no'                 => $member_no,
                    'first_name'                => $request['first_name'],
                    'middle_name'               => $request['middle_name'],
                    'last_name'                 => $request['last_name'],
                    'birthday'                  => $request['birthday'],
                    'birth_place'               => $request['birth_place'],
                    'gender'                    => $request['gender'],
                    'precinct_no'               => $request['precinct_no'],
                    'phone_number'              => $request['phone_number'],
                    'mobile_number'             => $request['mobile_number'],
                    'email_address'             => $request['email_address'],
                    'civil_status'              => $request['civil_status'],
                    'spouse_name'               => $request['spouse_name'],
                    'occupation'                => $request['occupation'],
                    'others_occupation'         => $request['others_occupation'],
                    'retiree'                   => $request['retiree'],
                    'religion'                  => $request['religion'],
                    'citizenship'               => $request['citizenship'],
                    'province'                  => $request['province'],
                    'province_code'             => $request['province_code'],
                    'municipality'              => $request['municipality'],
                    'municipality_code'         => $request['municipality_code'],
                    'barangay'                  => $request['barangay'],
                    'brgy_code'                 => $request['brgy_code'],
                    'residence_address'         => $request['residence_address'],
                    'residence_when'            => $request['residence_when'],
                    'mother_name'               => $request['mother_name'],
                    'father_name'               => $request['father_name'],
                    'government_id'             => $request['government_id'],
                    'em_contact_name'           => $request['em_contact_name'],
                    'em_relationship'           => $request['em_relationship'],
                    'em_phone_no'               => $request['em_phone_no'],
                    'em_mobile_no'              => $request['em_mobile_no'],
                    'em_address'                => $request['em_address'],
                    'agree_terms_condition'     => $request['agree_terms_condition'],
                    'date_created'              => date('Y-m-d H:i:s'),
                    'signature'                 => $request['signature'],
                    'selfie_img'                => $request['selfie_img'],
                    'date_sign'                 => $request['date_sign'],
                    'member_status'             => 'Active',
                    'member_designation'        => $this->input->post('member_type', true),
                );
                $member_id = $this->member_application->insert_member_details($insert_member);
                if ($member_id != '') {
                    $this->system_counter->increment_ctrl_num($this->counter_member);

                    $update_request = [
                        'request_status' => 'Approved',
                    ];
                    $this->member_application->process_approval($update_request, $application_id);

                    //Generate Account Details
                    $password = $this->generateRandomString();
                    $member_account = array(
                        'user_type_id'      => $this->input->post('member_type', true),
                        'username'          => $member_no,
                        'password'          => password_hash($password, PASSWORD_DEFAULT),
                        'temp_password'     => $password,
                        'date_created'      => date('Y-m-d H:i:s'),
                    );
                    $user_id = $this->member_application->insert_user_acct($member_account);
                    $this->member_application->update_member_details($user_id, $member_id);

                    //Insert Admin Info (BOARD or BARANGAY LEADER)
                    // $member_type = $this->input->post('member_type', true);
                    // if ($member_type != MEMBER) {
                    //     $user_details = array(
                    //         'user_id'       => $user_id,
                    //         'first_name'    => $request['first_name'],
                    //         'middle_name'   => $request['middle_name'],
                    //         'last_name'     => $request['last_name'],
                    //         'active_email'  => $request['email_address'],
                    //         'date_created'  => date('Y-m-d H:i:s'),
                    //     );
                    //     $this->member_application->insert_user_details($user_details);
                    // }

                    //Send email
                    $mail_data = [
                    	'name_to'   => $request['first_name'],
                        'username'  => $member_no,
                        'password'  => $password,
                    ];

                    $this->send_email_html([
                    	'mail_to'       => $request['email_address'],
                    	'cc'            => [],
                    	'subject'       => 'Congratulations [Membership Application Approved]',
                    	'template_path' => 'admin_portal/email/approved_request',
                    	'mail_data'     => $mail_data,
                    ]);

                    $success = 'Application successfully approved.';
                } else {
                    $error = 'Failed to update the data.';
                }
            }
        } else {
            //Declined Request
            $update_request = [
                'request_status' => 'Declined',
            ];

            $result = $this->member_application->process_approval($update_request, $application_id);
            if ($result == TRUE) {

                //Send email
                $mail_data = [
                    'name_to' => $request['first_name'].' '.$request['last_name'],
                ];

                $this->send_email_html([
                    'mail_to'       => $request['email_address'],
                    'cc'            => [],
                    'subject'       => 'Membership Application [Declined]',
                    'template_path' => 'admin_portal/email/decline_request',
                    'mail_data'     => $mail_data,
                ]);

                $success = 'Member appplication request successfully declined.';
            } else {
                $error = 'Failed to decline the request.';
            }
        }

        $output = array(
            'error' => $error,
            'success' => $success,
        );
        echo json_encode($output);
    }

    private function generateRandomString($length = 6)
    {
        $characters = '0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}