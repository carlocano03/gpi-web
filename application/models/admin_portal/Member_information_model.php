<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * @version 1.0
 * @author Carlo Cano <carlocano03@gmail.com>
 * @copyright Copyright &copy; 2023,
 *
 */
class Member_information_model extends MY_Model
{
    var $member = 'member_info';
    var $member_order = array('MI.member_no', 'MI.first_name', 'MI.last_name', 'MI.date_created', 'MI.status');
    var $member_search = array('MI.member_no', 'MI.first_name', 'MI.last_name', 'MI.date_created', 'MI.status'); //set column field database for datatable searchable just article , description , serial_num, property_num, department are searchable
    var $order_member = array('MI.member_id' => 'ASC'); // default order

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

    public function get_member_list()
    {
        $this->_get_member_list_query();
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_member()
    {
        $this->_get_member_list_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_member()
    {
        $status = $this->input->post('member_status', true);
        $this->db->select('MI.*, UT.name_type');
        $this->db->from($this->member.' MI');
        $this->db->join('user_type UT', 'MI.member_designation = UT.user_type_id', 'left');
        $this->db->where('MI.member_status', $status);
        return $this->db->count_all_results();
    }

    private function _get_member_list_query()
    {
        $status = $this->input->post('member_status', true);
        $this->db->select('MI.*, UT.name_type');
        $this->db->from($this->member.' MI');
        $this->db->join('user_type UT', 'MI.member_designation = UT.user_type_id', 'left');
        $this->db->where('MI.member_status', $status);
        $i = 0;
        foreach ($this->member_search as $item) // loop column 
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

                if (count($this->member_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->member_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_member)) {
            $order = $this->order_member;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function user_activation($update_member, $member_id)
    {
        $this->db->where('member_id', $member_id);
        $update = $this->db->update('member_info', $update_member);
        return $update?TRUE:FALSE;
    }

    function update_user_account($update_acct, $user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->update('user_acct', $update_acct);
    }

    function get_member_information($member_id)
    {
        $this->db->where('member_id', $member_id);
        $query = $this->db->get('member_info');
        return $query->row_array();
    }

    function get_member_info($member_id)
    {
        $this->db->select('*');
        $this->db->select("CONCAT(last_name, ', ', first_name, ' ', middle_name) as member_name");
        $this->db->from('member_info');
        $this->db->where('member_id', $member_id);
        $query = $this->db->get();
        return $query->row();
    }

    function update_member_info($update_member, $member_id)
    {
        $this->db->where('member_id', $member_id);
        $update = $this->db->update('member_info', $update_member);
        return $update?TRUE:FALSE;
    }
}