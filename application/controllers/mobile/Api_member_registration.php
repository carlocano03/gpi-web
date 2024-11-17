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
        $html = $this->load->view( 'admin_portal/pdf/copy_registration_pdf', $data['pdf_data'], true );

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
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        //Passport
        $base64DataPassport = $decodedData['passport_attachment'];
        $base64DataPassport = preg_replace('/^data:image\/(png|jpeg|jpg|gif);base64,/', '', $base64DataPassport);
        $binaryDataPassport = base64_decode($base64DataPassport);

        $mimeType = $finfo->buffer($binaryDataPassport);
        $extension = match($mimeType) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            default => 'jpg'
        };

        $filenamePassport = $decodedData['first_name'].'_passport'.rand(10000, 99999) . '_' . $dt . '.' . $extension;
        $uploadPathPassport  = 'assets/uploaded_file/member_application/passport/';
        file_put_contents($uploadPathPassport . $filenamePassport, $binaryDataPassport);
        //End of Passport

        //Selfie
        $base64DataSelfie = $decodedData['selfie_img'];
        $base64DataSelfie = preg_replace('/^data:image\/(png|jpeg|jpg|gif);base64,/', '', $base64DataSelfie);
        $binaryDataSelfie = base64_decode($base64DataSelfie);

        $mimeTypeSelfie = $finfo->buffer($binaryDataSelfie);
        $extensionSelfie = match($mimeTypeSelfie) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            default => 'jpg'
        };

        $filenameSelfie = $decodedData['first_name'].'_profile'.rand(10000, 99999) . '_' . $dt . '.' . $extensionSelfie;
        $uploadPathSelfie  = 'assets/uploaded_file/member_application/selfie_img/';
        file_put_contents($uploadPathSelfie . $filenameSelfie, $binaryDataSelfie);
        //End of Selfie

        //Signature
        $base64DataSignature = $decodedData['signature'];
        $base64DataSignature = preg_replace('/^data:image\/(png|jpeg|jpg|gif);base64,/', '', $base64DataSignature);
        $binaryDataSignature = base64_decode($base64DataSignature);

        $mimeTypeSign = $finfo->buffer($binaryDataSignature);
        $extensionSign = match($mimeTypeSign) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            default => 'jpg'
        };

        $filename = $decodedData['first_name'].'_sign'.rand(10000, 99999) . '_' . $dt . '.' . $extensionSign;
        $uploadPath  = 'assets/uploaded_file/member_application/signature/';
        file_put_contents($uploadPath . $filename, $binaryDataSignature);
        //End of Signature

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
                'gender'                    => $decodedData['gender'],
                'passport_no'               => $decodedData['passport_no'],
                'passport_attachment'       => $filenamePassport,
                'phone_number'              => $decodedData['phone_number'],
                'mobile_number'             => $decodedData['mobile_number'],
                'email_address'             => $decodedData['email_address'],
                'civil_status'              => $decodedData['civil_status'],
                'spouse_name'               => $decodedData['spouse_name'],
                'occupation'                => $decodedData['occupation'],
                'retiree'                   => $decodedData['retiree'],
                'business_address'          => $decodedData['business_address'],
                'business_phone_no'         => $decodedData['business_phone_no'],
                'business_mobile_no'        => $decodedData['business_mobile_no'],
                'em_contact_name'           => $decodedData['em_contact_name'],
                'em_relationship'           => $decodedData['em_relationship'],
                'em_phone_no'               => $decodedData['em_phone_no'],
                'em_mobile_no'              => $decodedData['em_mobile_no'],
                'em_address'                => $decodedData['em_address'],
                'first_ref_name'            => $decodedData['first_ref_name'],
                'first_ref_relationship'    => $decodedData['first_ref_relationship'],
                'first_ref_phone_no'        => $decodedData['first_ref_phone_no'],
                'first_ref_mobile_no'       => $decodedData['first_ref_mobile_no'],
                'first_ref_address'         => $decodedData['first_ref_address'],
                'sec_ref_name'              => $decodedData['sec_ref_name'],
                'sec_ref_relationship'      => $decodedData['sec_ref_relationship'],
                'sec_ref_phone_no'          => $decodedData['sec_ref_phone_no'],
                'sec_ref_mobile_no'         => $decodedData['sec_ref_mobile_no'],
                'sec_ref_address'           => $decodedData['sec_ref_address'],
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
                    'pdf_data'      => $this->api_member_registration_model->get_member_application($application_no),
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

}