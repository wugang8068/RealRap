<?php
/**
 * Created by PhpStorm.
 * User: wugang
 * Date: 16/9/6
 * Time: 14:45
 */

namespace RealRap;
abstract class Model
{

    /**
     * 表名
     * @var
     */
    protected $table;
    /**
     * 主键名
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * 属性列表
     * @var array
     */
    protected $attributes = [];

    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [];

    /**
     * 显示字段
     * @var array
     */
    protected $visible = [];

    /**
     * 附加字段
     * @var array
     */
    protected $appends = [];

    /**
     * 类型转换字段
     * @var array
     */
    protected $cast    = [];


    /**
     * 原始字段
     * @var array
     */
    protected $origins = [];


    /**
     * 填充字段
     * @var array
     */
    protected $fills = [];
    /**
     * @var Formatter
     */
    private $formatter;

    /**
     * @var
     */
    private $exists;
    /**
     * @var Builder
     */
    private $builder;
    /**
     * @param array $column
     * @return Builder
     */
    public static function all($column = ['*']){
        $builder = new Builder();
        $builder->setModel(new static);
        $builder->setColumn($column);
        return $builder;
    }

    /**
     * @param $where
     * @return Builder
     */
    public static function findWhere($where){
        $builder = self::all();
        $builder->where($where);
        return $builder;
    }


    /**
     * handle the result data
     * @param $queryResult
     * @return array
     */
    public function resultHandle($queryResult){
        $tempArray = [];
        foreach($queryResult as $row){
            $instance = new static;
            foreach($row as $key => $value){
                //如果不在隐藏字段中
                if(!in_array($key,$instance->hidden)){
                    //如果有转换字段,则对字段类型进行转换
                    if($instance->cast && isset($instance->cast[$key])){
                        $instance->$key = $instance->format($value,$instance->cast[$key]);
                    }else{
                        $instance->$key = $value;
                    }
                    if($instance->primaryKey != $key){
                        $instance->origins[] = $key;
                    }
                    if(isset($instance->attributes[$key])){
                        $replaceKey = $instance->attributes[$key];
                        $instance->$replaceKey = $instance->$key;
                        unset($instance->$key);
                    }
                }
            }
            $instance->exists = true;
            $tempArray[] = $instance;
        }
        return $tempArray;
    }

    /**
     * save or update data
     * @return bool
     */
    public function save(){
        $this->builder = $this->newBuilder();
        if($this->exists){
            $result = $this->builder->update();
        }else{
            $result = $this->builder->insert();
            if($result){
                $this->exists = true;
                $this->origins = array_merge($this->origins,array_keys($this->fills));
            }
        }
        return $result;
    }


    /**
     * delete this record from database
     * @return bool|mixed
     */
    public function delete(){
        $this->builder = $this->newBuilder();
        return $this->builder->delete();
    }

    /**
     * format the field value
     * @param $value
     * @param $cast
     * @return mixed
     * @throws Exception\ModelFormatException
     */
    private function format($value, $cast){
        if(!$this->formatter){
            $this->formatter = new Formatter();
        }
        return $this->formatter->format($value,$cast);
    }

    /**
     * @return array
     */
    public function getOriginFields(){
        return $this->origins;
    }

    /**
     * @return string
     */
    public function getPrimaryKey(){
        return $this->primaryKey;
    }

    /**
     * @return array
     */
    public function getAttributes(){
        return $this->attributes;
    }

    /**
     * @return mixed
     */
    public function getTable(){
        return $this->table;
    }

    /**
     * @return array
     */
    public function getFillsData(){
        return $this->fills;
    }


    /**
     * @return Builder
     */
    private function newBuilder(){
        if(!$this->builder){
            $this->builder = new Builder();
            $this->builder->setModel($this);
        }
        return $this->builder;
    }

    /**
     * @return mixed
     */
    public function isExists(){
        return $this->exists;
    }


    /**
     * return the primary key value
     * @return null
     */
    public function getPrimaryValue(){
        $primaryKey = $this->getPrimaryKey();
        if(isset($this->$primaryKey)){
            return $this->$primaryKey;
        }else{
            $originField = $this->getAttributes()[$primaryKey];
            if(isset($this->$originField)){
                return $this->$originField;
            }
        }
        return null;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
        $this->fills[$name] = $value;
    }
}