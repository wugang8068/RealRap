<?php
/**
 * Created by PhpStorm.
 * User: wugang
 * Date: 16/9/6
 * Time: 15:27
 */

namespace RealRap\Database;

use RealRap\Traits\RealRapDatabase;
use RealRap\Helper\ModelHelper;
use RealRap\Model\Model;
use RealRap\Database\BuilderJoin;

class Builder
{
    use RealRapDatabase;

    /**
     * @var Model
     */
    private $model;

    /**
     * @var array
     */
    private $column = ['*'];

    /**
     * @var array
     */
    private $where = [];

    /**
     * @var array
     */
    private $order = [];

    /**
     * @var
     */
    private $limit;

    /**
     * @var int
     */
    private $offset = 0;


    /**
     * @var BuilderJoin[]
     */
    private $joinRelations = [];

    /**
     * @param Model $model
     */
    public function setModel(Model &$model){
        if($this->model == null){
            $this->model = &$model;
        }
        return $this;
    }

    /**
     * @param $column
     */
    public function setColumn($column){
        $this->column = $column;
        return $this;
    }


    /**
     * filter
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
     * order
     * @param $order
     * @return $this
     */
    public function order($order){
        $this->order = array_merge($this->order,$order);
        return $this;
    }

    /**
     * @param $limit
     * @return $this
     */
    public function limit($limit){
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param $offset
     * @return $this
     */
    public function offset($offset){
        $this->offset = $offset;
        return $this;
    }


    /**
     * @param BuilderJoin $join
     */
    public function setJoin($join){
        $this->joinRelations[] = $join;
        return $this;
    }

    /**
     * 获取列表集合
     * @return Model[]
     */
    public function get(){
        $this->db->start_cache();
        $this->db->select($this->column);
        $this->db->from($this->model->getTable());
        if($this->where){
            $this->db->where($this->where);
        }
        if($this->order){
            foreach($this->order as $order => $sort){
                $this->db->order_by($order,$sort);
            }
        }
        if($this->limit){
            $this->db->limit($this->limit,$this->offset);
        }
        $query = $this->db->get();
        $tempArray = [];
        foreach($query->result_array() as $row){
            $tempArray[] = $row;
        }
        $this->db->flush_cache();
        return $this->model->resultHandle($tempArray);
    }


    /**
     * @return Model|null
     */
    public function getOne(){
        $this->limit(1);
        $result = $this->get();
        return $result ? $result[0] : null;
    }


    /**
     * @return bool|null
     * @throws \ErrorException
     */
    public function update(){
        if($updateArray = $this->getUpdateFieldAndValue()){
            if($this->where){
                $this->db->where($this->where);
            }else{
                $primaryValue = $this->model->getPrimaryValue();
                if(!$primaryValue){
                    throw new \ErrorException;
                }
                $this->db->where($this->model->getPrimaryKey(),$primaryValue);
            }
            return $this->db->update($this->model->getTable(),$updateArray);
        }
        return false;
    }

    /**
     * @return array|null
     */
    private function getUpdateFieldAndValue(){
        if($field = $this->model->getOriginFields()){
            $updateArray = [];
            foreach($field as $item){
                if(isset($this->model->$item)){
                    $updateArray[$item] = $this->model->$item;
                }
            }
            return $updateArray;
        }
        return null;
    }

    /**
     * @return bool
     */
    public function insert(){
        $fills = $this->model->getFillsData();
        $helper = new ModelHelper($this->model);
        $modelPublicAttribute = $helper->getPublicAttributes();
        $insertValues = [];
        foreach($fills as $key => $value){
            if(in_array($value,$modelPublicAttribute)){
                unset($fills[$key]);
                continue;
            }
            $insertValues[$key] = $value;
        }
        $insertResult = $this->db->insert($this->model->getTable(),$insertValues);
        if($insertResult) {
            $primaryKey = $this->model->getPrimaryKey();
            $this->model->$primaryKey = $this->db->insert_id();
            return true;
        }
        return false;
    }

    /**
     * @return bool|mixed
     */
    public function delete(){
        if($this->model && $this->model->isExists()){
            if($this->where){
                $this->db->where($this->where);
            }else if($primaryValue = $this->model->getPrimaryValue()){
                $this->db->where($this->model->getPrimaryKey(),$primaryValue);
            }else{
                die('Primary value is not exist');
            }
            return $this->db->delete($this->model->getTable());
        }else if($this->where){
            $this->db->where($this->where);
            return $this->db->delete($this->model->getTable());
        }
        return false;
    }
    /**
     * 获取最后一条sql
     * @return string
     */
    public function getLastQuery(){
        return $this->db->last_query();
    }
}