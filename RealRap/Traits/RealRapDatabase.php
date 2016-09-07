<?php
/**
 * Created by PhpStorm.
 * User: wugang
 * Date: 16/9/7
 * Time: 13:34
 */

namespace RealRap\Traits;


trait RealRapDatabase
{

    /**
     * @var \CI_Controller
     */
    public $ci;

    /**
     * @var \CI_DB_query_builder
     */
    private $db;

    public function __construct()
    {
        $this->ci = &get_instance();
        if(!isset($this->db)){
            $this->ci->load->database();
            $this->db = &$this->ci->db;
        }
    }
}