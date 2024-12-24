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
}