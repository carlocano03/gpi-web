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

    public function process_registration_post()
    {
        $error = '';
        $success = '';
        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData, true);

        //Increment counter
        $this->system_counter->increment_ctrl_num($this->counter_online_payment);
    }

}