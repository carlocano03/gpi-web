<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * @version 1.0
 * @author Carlo Cano <carlocano03@gmail.com>
 * @copyright Copyright &copy; 2023,
 *
 */
class Main_model extends MY_Model
{
    /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_total_member()
    {
        $query = $this->db->get('member_info');
        return $query->num_rows();
    }

    function get_member_count($status)
    {
        $this->db->where('member_status', $status);
        $this->db->where('status', 0);
        $query = $this->db->get('member_info');
        return $query->num_rows();
    }

    function get_pending_application()
    {
        $this->db->where('request_status', 'For Validation');
        $query = $this->db->get('application_request');
        return $query->num_rows();
    }
    
    private function verify_password_hash($password, $hash)
    {
        return password_verify($password, $hash);
    }


    function user_check($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->group_start();
            $this->db->where('user_type_id', ADMINISTRATOR);
            $this->db->or_where('user_type_id', BOARD_MEMBER);
            $this->db->or_where('user_type_id', BARANGAY_LEADER);
        $this->db->group_end();
        $res = $this->db->get('user_acct')->row_array();
        if (!$res) {
            return false;
        } else {
            $hash = $res['password'];
            if ($this->verify_password_hash($password, $hash)) {
                return $res;
            } else {
                return false;
            }
        }
    }

    function userCheck($username)
    {
        $this->db->where('username', $username);
        $this->db->group_start();
            $this->db->where('user_type_id', ADMINISTRATOR);
            $this->db->or_where('user_type_id', BOARD_MEMBER);
            $this->db->or_where('user_type_id', BARANGAY_LEADER);
        $this->db->group_end();
        $query = $this->db->get('user_acct');
        return $query->num_rows();
    }

    function get_user_details($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('admin_user_details');
        return $query->row_array();
    }

    function check_old_pass($old_pass) 
    {
        $this->db->where('user_id', $this->session->userdata('adminIn')['user_id']);
        $res = $this->db->get('user_acct')->row_array();
        if (!$res) {
            return false;
        } else {
            $hash = $res['password'];
            if ($this->verify_password_hash($old_pass, $hash)) {
                return $res;
            } else {
                return false;
            }
        }
    }

    function update_password($update_password)
    {
        $this->db->where('user_id', $this->session->userdata('adminIn')['user_id']);
        $update = $this->db->update('user_acct', $update_password);
        return $update?TRUE:FALSE;
    }

    function get_user_type()
    {
        $query = $this->db->get('user_type');
        return $query->result();
    }

}