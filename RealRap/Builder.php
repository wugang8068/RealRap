<?php
/**
 * Created by PhpStorm.
 * User: wugang
 * Date: 16/9/6
 * Time: 15:27
 */

namespace RealRap;


class Builder
{
    /**
     * @var \CI_Controller
     */
    private $ci;

    /**
     * @var Model
     */
    private $model;

    /**
     * @var array
     */
    private $column;

    private $where = [];

    private $order = [];

    public function __construct()
    {
        $this->ci = &get_instance();
        if(!isset($this->ci->db)){
            $this->ci->load->database();
        }
    }


    /**
     * @param Model $model
     */
    public function setModel(Model $model){
        $this->model = $model;
    }

    /**
     * @param $column
     */
    public function setColumn($column){
        $this->column = $column;
    }


    /**
     * 条件筛选字段
     * @param $where array
     * @return $this
     */
    public function where($where){
        if(is_array($where)){
            $this->where = array_merge($this->where,$where);
        }
        return $this;
    }

    /**
     * 排序字段
     * @param $order
     * @return $this
     */
    public function order($order){
        $this->order = array_merge($this->order,$order);
        return $this;
    }

    /**
     * 获取列表集合
     * @return array
     */
    public function get(){
        $db = &$this->ci->db;
        $db->start_cache();
        $db->select($this->column);
        $db->from($this->model->table);
        if($this->where){
            $db->where($this->where);
        }
        if($this->order){
            foreach($this->order as $order => $sort){
                $db->order_by($order,$sort);
            }
        }
        $query = $db->get();
        $tempArray = [];
        foreach($query->result_array() as $row){
            $tempArray[] = $row;
        }
        $db->flush_cache();
        return $this->model->resultHandle($tempArray);
    }

    /**
     * 获取最后一条sql
     * @return string
     */
    public function getLastQuery(){
        return $this->db->last_query();
    }
}