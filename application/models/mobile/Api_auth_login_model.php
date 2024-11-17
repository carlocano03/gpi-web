<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * @version 1.0
 * @author Carlo Cano <carlocano03@gmail.com>
 * @copyright Copyright &copy; 2022,
 *
 */

class Api_auth_login_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function user_check($username, $password) 
    {
        $this->db->where('username', $username);
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
        $query = $this->db->get('user_acct');
        return $query->num_rows();
    }

    function get_user_info($user_id)
    {
        $this->db->where('member_user_id', $user_id);
        $this->db->where('status', 0);
        $query = $this->db->get('member_info');
        return $query->row_array();
    }

    function check_password($user_id, $password)
    {
        $this->db->where('user_id', $user_id);
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

    function update_change_password($user_id, $update_password)
    {
        $this->db->where('user_id', $user_id);
        $update = $this->db->update('user_acct', $update_password);
        return $update?TRUE:FALSE;
    }

    function check_existing_mpin($user_id, $mpin_no)
    {
        // Retrieve the hash from the database where user_id matches
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('mobile_mpin');

        // Check if a record exists
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if ($this->verify_password_hash($mpin_no, $row->mpin_no)) {
                return true;
            }
        }
        return false;
    }

    function save_user_mpin($insert_mpin)
    {
        $insert = $this->db->insert('mobile_mpin', $insert_mpin);
        return $insert?TRUE:FALSE;
    }

    function user_check_pin($user_id, $mpin_no) 
    {
        $this->db->where('user_id', $user_id);
        $res = $this->db->get('mobile_mpin')->row_array();
        if (!$res) {
            return false;
        } else {
            $hash = $res['mpin_no'];
            if ($this->verify_password_hash($mpin_no, $hash)) {
                return $res;
            } else {
                return false;
            }
        }
    }

    function userCheckPin($user_id, $mpin_no)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('mobile_mpin');
        if ($query->num_rows() > 0) {
            $row = $query->row();

            if ($this->verify_password_hash($mpin_no, $row->mpin_no)) {
                return true; // MPIN is correct
            } else {
                return false; // MPIN is incorrect
            }
        } else {
            return false; // No record found for the user
        }
    }

    function userStatus($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('user_acct');
        return $query->row_array();
    }

    private function verify_password_hash($password, $hash)
    {
        return password_verify($password, $hash);
    }

    

}