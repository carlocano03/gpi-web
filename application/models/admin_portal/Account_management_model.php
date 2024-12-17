<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * @version 1.0
 * @author Carlo Cano <carlocano03@gmail.com>
 * @copyright Copyright &copy; 2023,
 *
 */
class Account_management_model extends MY_Model
{
    var $user = 'user_acct';
    var $user_order = array('AD.first_name', 'AD.middle_name', 'AD.last_name', 'AD.active_email', 'UA.is_active');
    var $user_search = array('AD.first_name', 'AD.middle_name', 'AD.last_name', 'AD.active_email', 'UA.is_active');
    var $order_user = array('UA.user_id' => 'ASC'); // default order

    var $permission = 'permissions';
    var $permission_order = array('perm_desc', 'date_created');
    var $permission_search = array('perm_desc', 'date_created'); //set column field database for datatable searchable just article , description , serial_num, property_num, department are searchable
    var $order_permission = array('perm_id' => 'ASC'); // default order
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

    public function get_account_list()
    {
        $this->_get_account_list_query();
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
	

    public function count_filtered()
    {
        $this->_get_account_list_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->select('UA.*, AD.first_name, AD.middle_name, AD.last_name, AD.active_email, UT.name_type');
        $this->db->from($this->user.' UA');
        $this->db->join('admin_user_details AD', 'UA.user_id = AD.user_id', 'left');
        $this->db->join('user_type UT', 'UA.user_type_id = UT.user_type_id', 'left');
        $this->db->where('UA.user_type_id', ADMIN_STAFF);
        return $this->db->count_all_results();
    }

    private function _get_account_list_query()
    {
        $this->db->select('UA.*, AD.first_name, AD.middle_name, AD.last_name, AD.active_email, UT.name_type');
        $this->db->from($this->user.' UA');
        $this->db->join('admin_user_details AD', 'UA.user_id = AD.user_id', 'left');
        $this->db->join('user_type UT', 'UA.user_type_id = UT.user_type_id', 'left');
        $this->db->where('UA.user_type_id', ADMIN_STAFF);
        $i = 0;
        foreach ($this->user_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->user_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->user_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_user)) {
            $order = $this->order_user;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function check_existing_user($email_add, $user_type)
    {
        $this->db->from('admin_user_details AD');
        $this->db->join('user_acct UA', 'AD.user_id = UA.user_id', 'left');
        $this->db->where('AD.active_email', $email_add);
        $this->db->where('UA.user_type_id', $user_type);
        $query = $this->db->get();
        return $query;
    }

    function insert_user_acct($insert_account)
    {
        $insert = $this->db->insert('user_acct', $insert_account);
        if ($insert) {
            return $this->db->insert_id();
        } else {
            return '';
        } 
    }

    function insert_user_details($user_details)
    {
        return $this->db->insert('admin_user_details', $user_details);
    }

    function update_account_details($update_account, $user_id)
    {
        $this->db->where('user_id', $user_id);
        $update = $this->db->update('admin_user_details', $update_account);
        return $update ? TRUE : FALSE;
    }

    function update_account($update_account, $user_id)
    {
        $this->db->where('user_id', $user_id);
        $update = $this->db->update('user_acct', $update_account);
        return $update ? TRUE : FALSE;
    }

    //Manage Permissions
    public function get_permission_list()
    {
        $this->_get_permission_list_query();
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_permission()
    {
        $this->_get_permission_list_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_permission()
    {
        $this->db->from($this->permission);
        $this->db->where('status', 0);
        return $this->db->count_all_results();
    }

    private function _get_permission_list_query()
    {
        $this->db->from($this->permission);
        $this->db->where('status', 0);
        $i = 0;
        foreach ($this->permission_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->permission_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->permission_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_permission)) {
            $order = $this->order_permission;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function checkUser_permission($userID, $perm_id)
    {
        $this->db->where('user_id', $userID);
        $this->db->where('perm_id', $perm_id);
        $query = $this->db->get('account_permissions');
        return $query->num_rows();
    }

    function update_permission_granted($update_permission, $userID, $perm_id)
    {
        $this->db->where('user_id', $userID);
        $this->db->where('perm_id', $perm_id);
        $update = $this->db->update('account_permissions', $update_permission);
        return $update?TRUE:FALSE;
    }

    function insert_permission_granted($insert_permission)
    {
        $insert = $this->db->insert('account_permissions', $insert_permission);
        return $insert?TRUE:FALSE;
    }

}