<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * @version 1.0
 * @author Carlo Cano <carlocano03@gmail.com>
 * @copyright Copyright &copy; 2022,
 *
 */

class Api_news_update_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function insert_news($insert_news)
    {
        $insert = $this->db->insert('news_update', $insert_news);
        return $insert?TRUE:FALSE;
    }

    function add_news_comment($insert_comment)
    {
        $insert = $this->db->insert('news_comment', $insert_comment);
        return $insert?TRUE:FALSE;
    }

    function get_all_news()
    {
        $this->db->select('NU.*, MI.member_no, MI.selfie_img');
        $this->db->select("CONCAT(MI.first_name, ' ', MI.last_name) as posted_name");
        $this->db->from('news_update NU');
        $this->db->join('member_info MI', 'NU.user_id = MI.member_user_id', 'left');
        $this->db->where('NU.is_deleted', NULL);
        $this->db->where('NU.status', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function get_comment_list($news_id)
    {
        $this->db->select('NC.*');
        $this->db->select("CONCAT(MI.first_name,' ',MI.last_name) as member_name");
        $this->db->from('news_comment NC');
        $this->db->join('member_info MI', 'NC.user_id = MI.member_user_id', 'left');
        $this->db->where('NC.news_id', $news_id);
        $this->db->where('NC.is_deleted IS NULL');
        $query = $this->db->get();
        return $query->result();
    }

}