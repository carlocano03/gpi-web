<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * @version 1.0
 * @author Carlo Cano <carlocano03@gmail.com>
 * @copyright Copyright &copy; 2023,
 *
 */
class Role_permission_model extends MY_Model
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

    function getUserPermissions($user_id)
    {
        $query = $this->db->select('perm_id')
                ->from('account_permissions')
                ->where('access', 'YES')
                ->where('user_id', $user_id)
                ->get();
        if ($query->num_rows() > 0) {
            $permissions = $query->result_array();
            return array_column($permissions, 'perm_id');
        }
        return array();
    }

    function get_auto_reply_info()
    {
        $query = $this->db->get('autoreply_credentials');
        return $query->row_array();
    }

}