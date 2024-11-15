<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * @version 1.0
 * @author Carlo Cano <carlocano03@gmail.com>
 * @copyright Copyright &copy; 2022,
 *
 */

class Api_member_registration_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function insert_application_request($insert_request)
    {
        $insert = $this->db->insert('application_request', $insert_request);
        return $insert?TRUE:FALSE;
    }

    function get_member_application($application_no)
    {
        $this->db->where('application_no', $application_no);
        $query = $this->db->get('application_request');
        return $query->row_array();
    }

    function check_existing_request($first_name, $last_name, $birthday)
    {
        $this->db->where('first_name', $first_name);
        $this->db->where('last_name', $last_name);
        $this->db->where('birthday', $birthday);
        $this->db->where('request_status !=', 'Declined');
        $query = $this->db->get('application_request');
        return $query->num_rows();
    }
}