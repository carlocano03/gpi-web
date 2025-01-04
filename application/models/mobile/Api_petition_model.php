<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * @version 1.0
 * @author Carlo Cano <carlocano03@gmail.com>
 * @copyright Copyright &copy; 2022,
 *
 */

class Api_petition_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function insert_new_petition($insert_petition)
    {
        $insert = $this->db->insert('petition_request', $insert_petition);
        return $insert?TRUE:FALSE;
    }

    function get_petition_list($user_id)
    {
        $this->db->where('created_by', $user_id);
        $this->db->where('is_deleted IS NULL');
        $this->db->where('status', 0);
        $query = $this->db->get('petition_request');
        return $query->result();
    }

    function get_total_community_petition($petition_id, $remarks)
    {
        $this->db->where('petition_id', $petition_id);
        $this->db->where('petition_remarks', $remarks);
        $this->db->where('status', 0);
        $this->db->select("COUNT(community_id) as total_count");
        $query = $this->db->get('community_petition');
        return $query->row();
    }

    function get_petition_info($petition_id)
    {
        $this->db->where('petition_id', $petition_id);
        $this->db->where('is_deleted IS NULL');
        $this->db->where('status', 0);
        $query = $this->db->get('petition_request');
        return $query->row();
    }

    //==========================BOARD MEMBER SIDE===========================
    function get_petition_list_approval()
    {
        $this->db->select('PR.*, MI.province, MI.barangay, MI.municipality, MI.residence_address, UT.name_type');
        $this->db->select("CONCAT(MI.last_name, ', ', MI.first_name, ' ', MI.middle_name) as created_by");
        $this->db->from('petition_request PR');
        $this->db->join('member_info MI', 'PR.created_by = MI.member_user_id', 'left');
        $this->db->join('user_type UT', 'MI.member_designation = UT.user_type_id', 'left');
        $this->db->where('PR.petition_remarks', 'For Approval');
        $this->db->where('PR.is_deleted IS NULL');
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_petition_approval_info($petition_id)
    {
        $this->db->select('PR.*, MI.province, MI.barangay, MI.municipality, MI.residence_address, UT.name_type');
        $this->db->select("CONCAT(MI.last_name, ', ', MI.first_name, ' ', MI.middle_name) as created_by");
        $this->db->from('petition_request PR');
        $this->db->join('member_info MI', 'PR.created_by = MI.member_user_id', 'left');
        $this->db->join('user_type UT', 'MI.member_designation = UT.user_type_id', 'left');
        $this->db->where('PR.is_deleted IS NULL');
        $this->db->where('PR.petition_id', $petition_id);
        $query = $this->db->get();
        return $query->row();
    }

    function petition_approval_process($update_petition, $petition_id)
    {
        $this->db->where('petition_id', $petition_id);
        $update = $this->db->update('petition_request', $update_petition);
        return $update?TRUE:FALSE;
    }
    //==========================END OF BM SIDE==============================
}