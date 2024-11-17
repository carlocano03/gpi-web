<?php
defined('BASEPATH') or exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *'); // for allow any domain, insecure
header('Access-Control-Allow-Headers: *'); // for allow any headers, insecure
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); // method allowed

require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;

class Api_auth_login extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mobile/api_auth_login_model', 'auth_login_model');
    }

    public function login_process_post()
    {
        $success = '';
        $error = '';
        $sess_array = array();
        // $username = $this->input->post('username', true);
        // $password = $this->input->post('password', true);

        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData, true);

        $username = $decodedData['username'];
        $password = $decodedData['password'];

        $result = $this->auth_login_model->user_check($username, $password);
        $userCheck = $this->auth_login_model->userCheck($username);

        if ($userCheck > 0) {
            if ($result) {
                if ($result['is_active'] == 1) {
                    $error = 'Account is deactivated';
                } elseif ($result['user_type_id'] != MEMBER_TYPE) {
                    $error = 'Ooops for members use only.';
                } else {
                    $user = $this->auth_login_model->get_user_info($result['user_id']);

                    if ($user['selfie_img'] == '') {
                        if ($user['gender'] == 1) {
                            $imagePath = base_url('assets/images/male-avatar.png');
                        } else {
                            $imagePath = base_url('assets/images/female-avatar.png');
                        } 
                    } else {
                        if ((file_exists('assets/uploaded_file/member_application/selfie_img/'.$user['selfie_img']))) {
                            $imagePath = base_url('assets/uploaded_file/member_application/selfie_img/'.$user['selfie_img']);
                        } else {
                            $imagePath = base_url('assets/images/logo-no-bg.png');
                        }
                    }

                    if ($result['with_mpin'] == 'YES') {
                        $with_mpin = 'YES';
                    } else {
                        $with_mpin = 'NO';
                    }

                    if ($result['temp_password'] =! '') {
                        $temp_password = 'YES';
                    } else {
                        $temp_password = 'NO';
                    }

                    $sess_array = array(
                        'user_id'       => $result['user_id'],
                        'user_type_id'  => $result['user_type_id'],
                        'email_address' => $user['email_address'],
                        'first_name'    => $user['first_name'],
                        'middle_name'   => $user['middle_name'],
                        'last_name'     => $user['last_name'],
                        'full_name'     => $user['first_name'].' '.$user['last_name'],
                        'with_mpin'     => $with_mpin,
                        'temp_password' => $temp_password,
                        'profile_pic'   => $imagePath,
                    );

                    $success = 'Login Success';
                }
            } else {
                $error = 'Please check your password.';
            }
        } else {
            $error = 'Invalid username.'; 
        }

        $output = array(
            'success' => $success,
            'error' => $error,
            'user_data' => $sess_array,
        );
        $this->response($output, RestController::HTTP_OK);
    }

    public function change_password_post()
    {
        $success = '';
        $error = '';
        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData, true);

        $user_id = $decodedData['user_id'];
        $current_password = $decodedData['current_password'];
        $new_password = $decodedData['new_password'];

        $check_password = $this->auth_login_model->check_password($user_id, $current_password);
        if ($check_password) {
            $update_password = array(
                'password' => password_hash($new_password, PASSWORD_DEFAULT),
                'temp_password' => '',
            );
            $result = $this->auth_login_model->update_change_password($user_id, $update_password);
            if ($result == TRUE) {
                $success = 'Password successfully updated.';
            } else {
                $error = 'Failed to update the password';
            }
        } else {
            $error = 'The current password does not match the record.';
        }
        $output = array(
            'error' => $error,
            'success' => $success,
        );
        $this->response($output, RestController::HTTP_OK);
    }

    //MPIN Process
    public function save_mpin_post()
    {
        $success = '';
        $error = '';
        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData, true);

        $user_id = $decodedData['user_id'];
        $mpin_no = $decodedData['mpin_no'];

        $check_existing = $this->auth_login_model->check_existing_mpin($user_id, $mpin_no);
        if ($check_existing) {
            $error = 'Already Exists';
        } else {
            $insert_mpin = array(
                'user_id'       => $user_id,
                'mpin_no'       => password_hash($mpin_no, PASSWORD_DEFAULT),
                'date_created'  => date('Y-m-d H:i:s'),
            );
            $result = $this->auth_login_model->save_user_mpin($insert_mpin);
            if ($result == TRUE) {
                $this->db->where('user_id', $user_id);
                $this->db->update('user_acct', array('with_mpin' => 'YES'));
                $success = 'Success';
            } else {
                $error = 'Error';
            }
        }

        $output = array(
			'success' => $success,
            'error' => $error,
		);
        $this->response($output, RestController::HTTP_OK);
    }

    public function login_mpin_post()
    {
        $success = '';
        $error = '';
        $sess_array = array();

        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData, true);

        $user_id = $decodedData['user_id'];
        $mpin_no = $decodedData['mpin_no'];

        $result_mpin = $this->auth_login_model->user_check_pin($user_id, $mpin_no);
        $userCheck = $this->auth_login_model->userCheckPin($user_id, $mpin_no);
        $result = $this->auth_login_model->userStatus($user_id);

        if ($userCheck) {
            if ($result_mpin) {
                if ($result['is_active'] == 1) {
                    $error = 'Account is deactivated';
                } elseif ($result['user_type_id'] != MEMBER_TYPE) {
                    $error = 'Ooops for members use only.';
                } else {
                    $user = $this->auth_login_model->get_user_info($result['user_id']);

                    if ($user['selfie_img'] == '') {
                        if ($user['gender'] == 1) {
                            $imagePath = base_url('assets/images/male-avatar.png');
                        } else {
                            $imagePath = base_url('assets/images/female-avatar.png');
                        } 
                    } else {
                        if ((file_exists('assets/uploaded_file/member_application/selfie_img/'.$user['selfie_img']))) {
                            $imagePath = base_url('assets/uploaded_file/member_application/selfie_img/'.$user['selfie_img']);
                        } else {
                            $imagePath = base_url('assets/images/logo-no-bg.png');
                        }
                    }

                    if ($result['with_mpin'] == 'YES') {
                        $with_mpin = 'YES';
                    } else {
                        $with_mpin = 'NO';
                    }

                    if ($result['temp_password'] =! '') {
                        $temp_password = 'YES';
                    } else {
                        $temp_password = 'NO';
                    }

                    $sess_array = array(
                        'user_id'       => $result['user_id'],
                        'user_type_id'  => $result['user_type_id'],
                        'email_address' => $user['email_address'],
                        'first_name'    => $user['first_name'],
                        'middle_name'   => $user['middle_name'],
                        'last_name'     => $user['last_name'],
                        'full_name'     => $user['first_name'].' '.$user['last_name'],
                        'with_mpin'     => $with_mpin,
                        'temp_password' => $temp_password,
                        'profile_pic'   => $imagePath,
                    );

                    $success = 'Login Success';
                }
            } else {
                $error = 'Please check your MPIN';
            }
        } else {
            $error = 'MPIN not found.'; 
        }
        $output = array(
            'success' => $success,
            'error' => $error,
            'user_data' => $sess_array,
        );
        $this->response($output, RestController::HTTP_OK);
    }

    //End of MPIN Process
}