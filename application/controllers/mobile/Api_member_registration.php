<?php
defined('BASEPATH') or exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *'); // for allow any domain, insecure
header('Access-Control-Allow-Headers: *'); // for allow any headers, insecure
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); // method allowed

require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;

class Api_member_registration extends RestController
{
    private $counter_member_application = MEMBER_APPLICATION;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mobile/api_member_registration_model');
        $this->load->model('System_counter_generator_model', 'system_counter');
    }

    private function send_email_attachment($data) 
    {
        require_once 'vendor/autoload.php';
        $this->load->model('role_permission_model');
        $emailCredentials = $this->role_permission_model->get_auto_reply_info();

        $mpdf = new \Mpdf\Mpdf( [ 
            'format' => 'A4-P',
            'margin_right' => 0,
            'margin_left' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0
        ]);
        $mpdf->showImageErrors = true;
        
        $data['pdf_data'] = $this->api_member_registration_model->get_member_application($data['application_no']);
        $html = $this->load->view( 'admin_portal/pdf/copy_registration_pdf', $data, true );

        $file = 'Membership Application-' .$data['application_no'];
        $pdfFilePath = FCPATH . "assets/uploaded_file/" . $file . ".pdf";
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath, "F");

		$this->load->library('email');
        $this->email->clear(TRUE);
        $config = [
            'protocol'  => $emailCredentials['protocol'],
            'smtp_host' => $emailCredentials['smtp_host'],
            'smtp_port' => $emailCredentials['smtp_port'],
            'smtp_user' => $emailCredentials['smtp_user'],
            'smtp_pass' => $emailCredentials['smtp_pass'],
            'smtp_crypto' => $emailCredentials['smtp_crypto'],
            'mailtype'  => $emailCredentials['mailtype'],
            'charset'   => $emailCredentials['charset'],
            'wordwrap'  => $emailCredentials['wordwrap'],
        ];
        $this->email->initialize($config);

        $mail_data = $data['mail_data'];
        $email_to = $data['mail_to'];
        $subject = $data['subject'];
        $template = $data['template_path'];
        
        $sender_name = 'GPI Portal';

        $body = $this->load->view($template, $mail_data, TRUE);
        
        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
		$this->email->from($emailCredentials['smtp_user'], $sender_name);
		$this->email->to($email_to);
		$this->email->subject($subject);
		$this->email->message($body);
        $this->email->attach($pdfFilePath);
        if($this->email->send()) {
            unlink($pdfFilePath);
			return TRUE;
		} else {
			log_message('error', $this->email->print_debugger());
			return FALSE;
		}
    }

    public function process_registration_post()
    {
        $error = '';
        $success = '';
        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData, true);
        $dt = Date('His');

        // Selfie
        if (!empty($decodedData['selfie_img'])) {
            $base64DataSelfie = $decodedData['selfie_img'];
            $base64DataSelfie = preg_replace('/^data:image\/(png|jpeg|jpg|gif);base64,/', '', $base64DataSelfie);
            $binaryDataSelfie = base64_decode($base64DataSelfie);

            if ($binaryDataSelfie !== false) {
                $filenameSelfie = $decodedData['first_name'] . 'profile' . rand(10000, 99999) . $dt . '.jpg';
                $uploadPathSelfie = 'assets/uploaded_file/member_application/selfie_img/';
                file_put_contents($uploadPathSelfie . $filenameSelfie, $binaryDataSelfie);
            } else {
                $filenameSelfie = '';
            }
        } else {
            $filenameSelfie = '';
        }
        // End of Selfie

        // Signature
        if (!empty($decodedData['signature'])) {
            $base64DataSignature = $decodedData['signature'];
            $base64DataSignature = preg_replace('/^data:image\/(png|jpeg|jpg|gif);base64,/', '', $base64DataSignature);
            $binaryDataSignature = base64_decode($base64DataSignature);

            if ($binaryDataSignature !== false) {
                $filename = $decodedData['first_name'] . '_sign' . rand(10000, 99999) . '_' . $dt . '.png';
                $uploadPath = 'assets/uploaded_file/member_application/signature/';
                file_put_contents($uploadPath . $filename, $binaryDataSignature);
            } else {
                $filename = '';
            }
        } else {
            $filename = '';
        }
        // End of Signature

        //Government ID
        if (!empty($decodedData['government_id'])) {
            $base64DataID = $decodedData['government_id'];
            $base64DataID = preg_replace('/^data:image\/(png|jpeg|jpg|gif);base64,/', '', $base64DataID);
            $binaryDataID = base64_decode($base64DataID);

            if ($binaryDataID !== false) {
                $filenameID = $decodedData['first_name'] . '_government' . rand(10000, 99999) . '_' . $dt . '.jpg';
                $uploadPathID = 'assets/uploaded_file/member_application/government_id/';
                file_put_contents($uploadPathID . $filenameID, $binaryDataID);
            } else {
                $filenameID = '';
            }
        } else {
            $filenameID = '';
        }
        // End of ID


        $application_no = $this->system_counter->get_ctrl_num_cv($this->counter_member_application);
        $first_name = $decodedData['first_name'];
        $last_name = $decodedData['last_name'];
        $birthday = $decodedData['birthday'];

        $check_existing = $this->api_member_registration_model->check_existing_request($first_name, $last_name, $birthday);
        if ($check_existing > 0) {
            $error = 'Exist';
        } else {
            $insert_request = array(
                'application_no'            => $application_no,
                'first_name'                => $decodedData['first_name'],
                'middle_name'               => $decodedData['middle_name'],
                'last_name'                 => $decodedData['last_name'],
                'birthday'                  => $decodedData['birthday'],
                'birth_place'               => $decodedData['birth_place'],
                'gender'                    => $decodedData['gender'],
                'precinct_no'               => $decodedData['precinct_no'],
                'phone_number'              => $decodedData['phone_number'],
                'mobile_number'             => $decodedData['mobile_number'],
                'email_address'             => $decodedData['email_address'],
                'civil_status'              => $decodedData['civil_status'],
                'spouse_name'               => $decodedData['spouse_name'],
                'occupation'                => str_replace('_', ' ', $decodedData['occupation']),
                'others_occupation'         => $decodedData['occupation_others'],
                'retiree'                   => $decodedData['retiree'],
                'religion'                  => $decodedData['religion'],
                'citizenship'               => $decodedData['citizenship'],
                'province'                  => $decodedData['province'],
                'municipality'              => $decodedData['municipality'],
                'barangay'                  => $decodedData['barangay'],
                'residence_address'         => $decodedData['residence_address'],
                'residence_when'            => $decodedData['resident_since'],
                'mother_name'               => $decodedData['mother_name'],
                'father_name'               => $decodedData['father_name'],
                'government_id'             => $filenameID,
                'em_contact_name'           => $decodedData['em_contact_name'],
                'em_relationship'           => $decodedData['em_relationship'],
                'em_phone_no'               => $decodedData['em_phone_no'],
                'em_mobile_no'              => $decodedData['em_mobile_no'],
                'em_address'                => $decodedData['em_address'],
                'agree_terms_condition'     => $decodedData['agree_terms_condition'],
                'date_created'              => date('Y-m-d H:i:s'),
                'request_status'            => 'For Validation',
                'signature'                 => $filename,
                'selfie_img'                => $filenameSelfie,
                'date_sign'                 => date('Y-m-d'),
            );
    
            $result = $this->api_member_registration_model->insert_application_request($insert_request);
            if ($result == TRUE) {
    
                //Send email
                $mail_data = [
                    'name_to' => $decodedData['first_name'].' '.$decodedData['last_name'],
                ];
    
                $this->send_email_attachment([
                    'mail_to'       => $decodedData['email_address'],
                    'cc'            => [],
                    'subject'       => 'Membership Application [For Approval]',
                    'template_path' => 'admin_portal/email/success_registration',
                    'application_no' => $application_no,
                    'mail_data'     => $mail_data,
                ]);
    
                //Increment counter
                $this->system_counter->increment_ctrl_num($this->counter_member_application);
                $success = 'Success';
            } else {
                $error = 'Error';
            }
        }
        $output = [
            'success' => $success,
            'error' => $error,
        ];
        $this->response($output, RestController::HTTP_OK);
    }

    public function religion_get()
    {
        $religion = $this->api_member_registration_model->get_religion_list();
        $religionArray = array();

        foreach($religion as $list) {
            $religionArray[] = array(
                'religion_name' => $list->religion_name,
            );
        }

        $output = array(
            'religion' => $religionArray,
        );

        $this->response($output, RestController::HTTP_OK);
    }

    public function occupation_get()
    {
        $occupation = $this->api_member_registration_model->get_occupation_list();
        $occupationArray = array();

        foreach($occupation as $list) {
            $occupationArray[] = array(
                'name' => $list->name,
            );
        }

        $output = array(
            'occupation' => $occupationArray,
        );

        $this->response($output, RestController::HTTP_OK);
    }

    //PSGC
    public function province_get()
    {
        $province = $this->api_member_registration_model->get_province_list();
        $provinceArray = array();

        foreach($province as $list) {
            $provinceArray[] = array(
                'code'          => $list->code,
                'name'          => ucwords($list->name),
            );
        }

        $this->response($provinceArray, RestController::HTTP_OK);
    }

    public function municipality_post()
    {
        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData, true);

        $code = $decodedData['code'];

        // $code = $this->input->post('code');
        $res = $this->db->like('code',substr($code,0,4),'after')->order_by('name', 'ASC')->get('psgc_municipal')->result();
        $municipalArray = array();

        foreach($res as $list) {
            $municipalArray[] = array(
                'code'          => $list->code,
                'name'          => ucwords($list->name),
            );
        }

        $this->response($municipalArray, RestController::HTTP_OK);
    }

    public function barangay_post()
    {
        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData, true);

        $code = $decodedData['code'];

        // $code = $this->input->post('code');
        $brgy = $this->db->like('code',substr($code,0,6),'after')->order_by('name', 'ASC')->get('psgc_brgy')->result();
        $barangayArray = array();

        foreach($brgy as $list) {
            $barangayArray[] = array(
                'code'          => $list->code,
                'name'          => ucwords($list->name),
            );
        }

        $this->response($barangayArray, RestController::HTTP_OK);
    }



}