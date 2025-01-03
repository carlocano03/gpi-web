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

    function get_religion_list()
    {
        $this->db->where('status', 0);
        $query = $this->db->get('religion');
        return $query->result();
    }

    function get_occupation_list()
    {
        $this->db->where('status', 0);
        $query = $this->db->get('occupation');
        return $query->result();
    }

    //PSGC
    function get_province_list()
    {
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('psgc_province');
        return $query->result();
    }
}