<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

/**
*
* @version 1.0
* @author Carlo Cano <carlocano03gmail.com>
* @copyright Copyright &copy; 2022,
*
*/

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set( TIMEZONE );
        $this->lang->load('system_lang');
    }

    // Unset session data

    public function unset_session() {
        $this->session->sess_destroy();
    }

    public function check_session($sessionKey, $redirectUrl) {
        if (!$this->session->userdata($sessionKey)) {
            redirect($redirectUrl);
        }
    }

    // Removes array keys
    function remove_array_keys( $array ) {
        foreach ( $array as $k => $v ) {
            if ( is_array( $v ) ) {
                $array[ $k ] = $this->remove_array_keys( $v );
            }
            //if
        }
        //foreach
        return $this->sort_numeric_keys( $array );
    }

    // re-index the array starting from zero

    function sort_numeric_keys( $array ) {
        $i = 0;
        foreach ( $array as $k => $v ) {
            if ( is_int( $k ) ) {
                $rtn[ $i ] = $v;
                $i++;
            } else {
                $rtn[ $k ] = $v;
            }
            //if
        }
        //foreach
        return $rtn;
    }

    protected function append_csrf_token_info_into( &$response ) {
        $response[ 'token_name' ] = $this->security->get_csrf_token_name();
        $response[ 'token_value' ] = $this->security->get_csrf_hash();
    }

    protected function response_json( $response, $code = 200 ) {
        $this->output
        ->set_status_header( $code )
        ->set_content_type( 'application/json', 'utf-8' )
        ->set_output( json_encode( $response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) )
        ->_display();
        exit;
    }

    function role_permissions()
    {
        $this->load->model('role_permission_model');
        $user_id = $this->session->userdata('adminIn')['user_id'];

        $user_permissions = $this->role_permission_model->getUserPermissions($user_id);
        return $user_permissions;
    }

    function insert_activity_logs($logs)
    {
        $this->load->model('main_model');
        $this->main_model->insert_activity_logs($logs);
    }

    function send_email_html($data) 
    {
        $this->load->model('role_permission_model');
        $emailCredentials = $this->role_permission_model->get_auto_reply_info();
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
        if($this->email->send()) {
			return TRUE;
		} else {
			log_message('error', $this->email->print_debugger());
			return FALSE;
		}
    }

    function send_email_attachment($data) 
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

}