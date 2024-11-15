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

    function applicationChart($range='')
    {
        $today = date('Y-m-d');
        $prevRange = date('Y-m-d', strtotime('-1 week'));

        if ($range == '1') {
            $prevRange = date('Y-m-d', strtotime('-1 week'));
        } elseif ($range == '2') {
            $prevRange = date('Y-m-d', strtotime('-1 month'));
        } elseif ($range == '3') {
            $prevRange = date('Y-m-d', strtotime('-1 year'));
        }

        $dateRange = [];
        $currentDate = $today;
        while ($currentDate >= $prevRange) {
            $dateRange[] = $currentDate;
            $currentDate = date('Y-m-d', strtotime('-1 day', strtotime($currentDate)));
        }

        $dateRange = array_reverse($dateRange);

        $selectColumns = [];
        foreach ($dateRange as $date) {
            $selectColumns[] = "IFNULL(COUNT(DISTINCT CASE WHEN DATE(date_created) = '$date' THEN application_id ELSE NULL END), 0) AS '$date'";
        }

        // Query for total application
        $this->db->select('\'Total Application\' AS application_status', FALSE);
        $this->db->select('IFNULL(COUNT(application_id), 0) AS total_count', FALSE);
        $this->db->select(implode(', ', $selectColumns));
        $this->db->from('application_request');
        $this->db->where('status', 0);
        $this->db->where('date_created >=', $prevRange.' 00:00:00');
        $this->db->where('date_created <=', $today.' 23:59:59');
        $application = $this->db->get()->row_array();

        // Query for total approved
        $this->db->select('\'Approved\' AS application_status', FALSE);
        $this->db->select('IFNULL(COUNT(application_id), 0) AS total_count', FALSE);
        $this->db->select(implode(', ', $selectColumns));
        $this->db->from('application_request');
        $this->db->where('request_status', 'Approved');
        $this->db->where('date_created >=', $prevRange.' 00:00:00');
        $this->db->where('date_created <=', $today.' 23:59:59');
        $approved = $this->db->get()->row_array();

        // Query for total declined
        $this->db->select('\'Declined\' AS application_status', FALSE);
        $this->db->select('IFNULL(COUNT(application_id), 0) AS total_count', FALSE);
        $this->db->select(implode(', ', $selectColumns));
        $this->db->from('application_request');
        $this->db->where('request_status', 'Declined');
        $this->db->where('date_created >=', $prevRange.' 00:00:00');
        $this->db->where('date_created <=', $today.' 23:59:59');
        $declined = $this->db->get()->row_array();

        // Ensure all date columns are set to 0 if not present
        foreach ($dateRange as $date) {
            if (!isset($application[$date])) {
                $application[$date] = '0';
            }
            if (!isset($approved[$date])) {
                $approved[$date] = '0';
            }
            if (!isset($declined[$date])) {
                $declined[$date] = '0';
            }
        }
        
        return array(
            $application,
            $approved,
            $declined
        );
    }

}