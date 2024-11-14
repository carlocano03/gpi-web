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
    }
}