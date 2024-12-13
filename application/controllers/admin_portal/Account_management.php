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

class Account_management extends MY_Controller
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
        $this->load->model('admin_portal/account_management_model', 'account_management');

        $this->output->set_header("X-Robots-Tag: noindex");
        $this->output->set_header('Cache-Control: no-store, no-cache');
        
        //Check Session
        $this->check_session('adminIn', 'admin/login');
    } //End __construct

    public function get_admin_account()
    {
        $account = $this->account_management->get_account_list();
        $data = array();
        $no = $_POST['start'];
        foreach ($account as $list) {
            $no++;
            $row = array();

            $fullname = $list->last_name.', '.$list->first_name.' '.$list->middle_name;

            $row[] = $no;
            $row[] = '<div>'.ucwords($fullname).'</div>
                      <span style="color: red; font-size:10px; font-weight:600;">Designation: '.$list->name_type.'</span>';
            $row[] = $list->username;
            $row[] = $list->active_email;

            if ($list->is_active == 1) {
                $row[] = '<label class="switch">
							  <input type="checkbox" class="account_activation" id="' . $list->user_id . '">
							  <span class="slider round"></span>
					  	  </label><br>Not Active';
            } else {
                $row[] = '<label class="switch">
							  <input type="checkbox" class="account_activation" id="' . $list->user_id . '" checked>
							  <span class="slider round"></span>
					  	  </label><br>Active';
            }

            $action_btn = '<div class="btn-group">
                            <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item link-cursor text-primary add_permission" id="'.$list->user_id.'"><i class="bi bi-lock-fill me-2"></i>Add Permission</a></li>
                                <li><a class="dropdown-item link-cursor text-warning update_account"
                                    data-id="'.$list->user_id.'"
                                    data-fname="'.$list->first_name.'"
                                    data-mname="'.$list->middle_name.'"
                                    data-lname="'.$list->last_name.'"
                                    data-email="'.$list->active_email.'"
                                ><i class="bi bi-pencil-square me-2"></i>Update Account</a></li>
                                <li><a class="dropdown-item link-cursor text-danger" id="send_credentials" data-id="'.$list->user_id.'"><i class="bi bi-send-fill me-1"></i>Resend Credentials</a></li>
                            </ul>
                        </div>';

            $row[] = $action_btn;

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->account_management->count_all(),
            "recordsFiltered" => $this->account_management->count_filtered(),
            "data" => $data,
            "csrf_token_value" => $this->security->get_csrf_hash(),
            "csrf_token_name" => $this->security->get_csrf_token_name(),
        );
        echo json_encode($output);
    }

    public function save_new_account()
    {
        $error = '';
        $success = '';

        $first_name = $this->input->post('first_name', true);
        $middle_name = $this->input->post('middle_name', true);
        $last_name = $this->input->post('last_name', true);
        $email_add = $this->input->post('email_add', true);
        $user_type = ADMIN_STAFF;

        $smallFname = strtolower($first_name);
        $smallLname = strtolower($last_name);

        $check_user = $this->account_management->check_existing_user($email_add, $user_type);
        if ($check_user->num_rows() > 0) {
            $error = 'Admin Staff account already exist.';
        } else {
            $password = $this->generateRandomString();
            $username = str_replace(' ','', $smallFname).str_replace(' ','', $smallLname).mt_rand(10000,99999);
            $insert_account = array(
                'user_type_id'      => $user_type,
                'username'          => $username,
                'password'          => password_hash($password, PASSWORD_DEFAULT),
                'temp_password'     => $password,
                'date_created'      => date('Y-m-d H:i:s'),
            );
            $user_id = $this->account_management->insert_user_acct($insert_account);
            if ($user_id != '') {
                $user_details = array(
                    'user_id'       => $user_id,
                    'first_name'    => $first_name,
                    'middle_name'   => $middle_name,
                    'last_name'     => $last_name,
                    'active_email'  => $email_add,
                    'date_created'  => date('Y-m-d H:i:s'),
                );
                $this->account_management->insert_user_details($user_details);

                //Send Email
                $mail_data = [
                	'name_to'   => $first_name,
                    'username'  => $username,
                    'password'  => $password,
                    'login_url' => base_url('admin/login'),
                    'user_level' => 'Admin Staff',
                ];

                $this->send_email_html([
                	'mail_to'       => $email_add,
                	'cc'            => [],
                	'subject'       => 'Account Credentials [Admin Staff]',
                	'template_path' => 'admin_portal/email/admin_credentials',
                	'mail_data'     => $mail_data,
                ]);

                $success = 'Admin Staff account created successfully.';
            } else {
                $error = 'Failed to create a account.';
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
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function update_account()
    {
        $error = '';
        $success = '';

        $user_id = $this->input->post('user_id', true);
        $first_name = $this->input->post('first_name', true);
        $middle_name = $this->input->post('middle_name', true);
        $last_name = $this->input->post('last_name', true);
        $email_add = $this->input->post('email_add', true);

        $update_account = array(
            'first_name'    => $first_name,
            'middle_name'   => $middle_name,
            'last_name'     => $last_name,
            'active_email'  => $email_add,
        );
        $result = $this->account_management->update_account_details($update_account, $user_id);
        if ($result == TRUE) {
            $success = 'Account information successfully updated.';
        } else {
            $error = 'Failed to update the data.';
        }
        $output = array(
            'error' => $error,
            'success' => $success,
        );
        echo json_encode($output);
    }

    public function account_activation()
    {
        $message = '';
        $action = $this->input->post('action', true);
        $user_id = $this->input->post('user_id', true);

        if ($action == 'Activate') {
            $update_account = array(
                'is_active' => 0,//Active
            ); 
        } else {
            $update_account = array(
                'is_active' => 1,//Deactivate
            ); 
        }
        $result = $this->account_management->update_account($update_account, $user_id);
        if ($result == TRUE) {
            $message = 'Success';
        } else {
            $message = 'Error';
        }
        $output['message'] = $message;
        echo json_encode($output);
    }

    public function get_Permission()
    {
        $user_id = $this->input->post('user_id');
        $list = $this->account_management->get_permission_list();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $account) {
            $no++;
            $row = array();

            $query = $this->db->query("
                SELECT * FROM account_permissions WHERE perm_id = '" . $account->perm_id . "'
                AND user_id = '" . $user_id . "'
            ");

            $res = $query->row();
            if (isset($res->access) && $res->access == 'YES')
                $row[] = '<span>'.$account->perm_desc.'</span>';
            else
                $row[] = $account->perm_desc;

            if (isset($res->access) && $res->access == 'YES') {
                $row[] = '<label class="switch">
							  <input type="checkbox" class="apply_permission" id="' . $account->perm_id . '" data-user="' . $user_id . '" checked>
							  <span class="slider round"></span>
					  	  </label><br>ON';
            } else {
                $row[] = '<label class="switch">
						  <input type="checkbox" class="apply_permission" id="' . $account->perm_id . '" data-user="' . $user_id . '">
						  <span class="slider round"></span>
					  	 </label><br>OFF';
            } 
            $data[] = $row;  
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->account_management->count_all_permission(),
            "recordsFiltered" => $this->account_management->count_filtered_permission(),
            "data" => $data,
            "csrf_token_value" => $this->security->get_csrf_hash(),
            "csrf_token_name" => $this->security->get_csrf_token_name(),
        );
        echo json_encode($output);
    }

    public function apply_permission()
    {
        $message = '';
        $userID = $this->input->post('userID');
        $perm_id = $this->input->post('perm_id');
        $action = $this->input->post('action');

        if ($action == 'Grant') {
            $checkUser = $this->account_management->checkUser_permission($userID, $perm_id);
            if ($checkUser > 0) {
                $update_permission = array(
                    'access' => 'YES',
                );
                $update = $this->account_management->update_permission_granted($update_permission, $userID, $perm_id);
                if ($update == TRUE) {
                    $message = 'Success';
                } else {
                    $message = 'Error';
                }
            } else {
                $insert_permission = array(
                    'user_id' => $userID,
                    'perm_id' => $perm_id,
                    'access' => 'YES',
                    'date_created' => date('Y-m-d H:i:s'),
                );
                $result = $this->account_management->insert_permission_granted($insert_permission);
                if ($result == TRUE) {
                    $message = 'Success';
                } else {
                    $message = 'Error';
                }
            }
        } else {
            //Remove Permission
            $update_permission = array(
                'access' => 'NO',
            );
            $update = $this->account_management->update_permission_granted($update_permission, $userID, $perm_id);
            if ($update == TRUE) {
                $message = 'Success';
            } else {
                $message = 'Error';
            }
        }
        $output['message'] = $message;
        echo json_encode($output);
    }

    public function resend_credentials()
    {
        $error = '';
        $success = '';
        $user_id = $this->input->post('user_id', true);
        $user_type = ADMIN_STAFF;
        $password = $this->generateRandomString();

        $user_details = $this->account_management->get_row('admin_user_details', array('user_id' => $user_id));
        $template_path = 'email_template/admin_side_credentials';
        $first_name = $user_details['first_name'];
        $url_link = base_url('admin/login');
        $email_add = $user_details['active_email'];

        $user_acct = $this->account_management->get_row('user_acct', array('user_id' => $user_id));

        $update_account = array(
            'password'          => password_hash($password, PASSWORD_DEFAULT),
            'temp_password'     => $password,
        );

        $result = $this->account_management->update_account($update_account, $user_id);
        if ($user_id == TRUE) {
            //Send Email
            $mail_data = [
            	'name_to' => $first_name,
                'username' => $user_acct['username'],
                'password' => $password,
                'login_url' => $url_link,
                'user_level' => 'Admin Staff',
            ];

            $this->send_email_html([
            	'mail_to'       => $email_add,
            	'cc'            => [],
            	'subject'       => 'Account Credentials',
            	'template_path' => $template_path,
            	'mail_data'     => $mail_data,
            ]);

            $success = 'Success';
        } else {
            $error = 'Failed to resend the credentials.';
        }
        $output = array(
            'error' => $error,
            'success' => $success,
        );
        echo json_encode($output);
    }
}