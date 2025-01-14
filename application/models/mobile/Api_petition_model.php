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
        $this->db->select('PR.*');
        $this->db->select("CONCAT(MI.first_name, ' ', MI.last_name) as created_by");
        $this->db->from('petition_request PR');
        $this->db->join('member_info MI', 'PR.created_by = MI.member_user_id', 'left');
        $this->db->where('PR.created_by', $user_id);
        $this->db->where('PR.is_deleted IS NULL');
        $this->db->where('PR.status', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function get_total_barangay_member($user_id)
    {
        $this->db->where('member_user_id', $user_id);
        $leader = $this->db->get('member_info')->row_array();
        if ($leader) {
            $this->db->where('brgy_code', $leader['brgy_code']);
            $this->db->where('status', 0);
            $this->db->where('member_designation', MEMBER_TYPE);
            $query = $this->db->get('member_info');
            return $query->num_rows();
        } else {
            return 0;
        }

    }

    function get_total_member_count()
    {
        $this->db->where('status', 0);
        $this->db->where('member_designation', MEMBER_TYPE);
        $query = $this->db->get('member_info');
        return $query->num_rows();
    }

    function get_total_member($brgy_code)
    {
        $this->db->where('brgy_code', $brgy_code);
        $this->db->where('status', 0);
        $this->db->where('member_designation', MEMBER_TYPE);
        $query = $this->db->get('member_info');
        return $query->num_rows();
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

    function get_list_member_sign($petition_id)
    {
        $this->db->select('CP.petition_remarks, CP.date_created, MI.selfie_img, MI.member_no, MI.email_address');
        $this->db->select("CONCAT(MI.first_name, ' ', MI.last_name) as signed_by");
        $this->db->from('community_petition CP');
        $this->db->join('member_info MI', 'CP.member_id = MI.member_user_id', 'left');
        $this->db->where('CP.petition_id', $petition_id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_petition_count($status, $user_id)
    {
        $this->db->where('petition_remarks', $status);
        $this->db->where('created_by', $user_id);
        $this->db->where('is_deleted IS NULL');
        $query = $this->db->get('petition_request');
        return $query->num_rows();
    }

    function get_member_count($barangay)
    {
        $this->db->where('brgy_code', $barangay);
        $this->db->where('status', 0);
        $this->db->where('member_designation', MEMBER_TYPE);
        $query = $this->db->get('member_info');
        return $query->num_rows();
    }

    //==========================BOARD MEMBER SIDE===========================
    function get_petition_list_approval($status)
    {
        $this->db->select('PR.*, MI.province, MI.barangay, MI.municipality, MI.residence_address, UT.name_type');
        $this->db->select("CONCAT(MI.last_name, ', ', MI.first_name, ' ', MI.middle_name) as created_by");
        $this->db->from('petition_request PR');
        $this->db->join('member_info MI', 'PR.created_by = MI.member_user_id', 'left');
        $this->db->join('user_type UT', 'MI.member_designation = UT.user_type_id', 'left');
        $this->db->where('PR.petition_remarks', $status);
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

    //==========================MEMBER SIDE===========================
    function get_barangay_petition($brgy_code)
    {
        $this->db->select('PR.*');
        $this->db->select("CONCAT(MI.first_name, ' ', MI.last_name) as created_by");
        $this->db->from('petition_request PR');
        $this->db->join('member_info MI', 'PR.created_by = MI.member_user_id', 'left');
        $this->db->where('PR.is_deleted IS NULL');
        $this->db->where('PR.barangay', $brgy_code);
        $this->db->where('PR.petition_remarks', 'Approved');
        $this->db->where('PR.status', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function check_member_sign($petition_id, $member_id)
    {
        $this->db->where('petition_id', $petition_id);
        $this->db->where('member_id', $member_id);
        $this->db->where('status', 0);
        $query = $this->db->get('community_petition');
        return $query;
    }

    function insert_community_petition($insert_signature)
    {
        $insert = $this->db->insert('community_petition', $insert_signature);
        return $insert?TRUE:FALSE;
    }
    //==========================END OF MEMBER SIDE==============================

}