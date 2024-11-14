<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * @version 1.0
 * @author Carlo Cano <carlocano03@gmail.com>
 * @copyright Copyright &copy; 2023,
 *
 */
class Member_application_model extends MY_Model
{
    var $request = 'application_request';
    var $request_order = array('application_no', 'first_name', 'last_name', 'date_created', 'request_status');
    var $request_search = array('application_no', 'first_name', 'last_name', 'date_created', 'request_status'); //set column field database for datatable searchable just article , description , serial_num, property_num, department are searchable
    var $order_request = array('application_id' => 'ASC'); // default order

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

    public function get_member_application()
    {
        $this->_get_member_application_query();
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_member_application_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->request);
        $this->db->where('request_status', 'For Validation');
        return $this->db->count_all_results();
    }

    private function _get_member_application_query()
    {
        $this->db->from($this->request);
        $this->db->where('request_status', 'For Validation');
        $i = 0;
        foreach ($this->request_search as $item) // loop column 
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

                if (count($this->request_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->request_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_request)) {
            $order = $this->order_request;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

}