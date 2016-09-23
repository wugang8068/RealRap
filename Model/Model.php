<?php
/**
 * Created by PhpStorm.
 * User: wugang
 * Date: 16/9/6
 * Time: 14:45
 */

namespace RealRap\Model;
use RealRap\Exception\ModelNotFoundException;
use RealRap\Exception\ModelFormatException;
use RealRap\Relation\OneToMany;
use RealRap\Relation\OneToOne;
use RealRap\Relation\Relation;
use RealRap\Relation\RelationQueryHandle;
use RealRap\Database\Builder;
use RealRap\Formatter;

abstract class Model
{

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $visible = [];

    /**
     * @var array
     */
    protected $appends = [];

    /**
     * @var array
     */
    protected $cast    = [];


    /**
     * @var array
     */
    protected $origins = [];

    /**
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
     * @var array
     */
    private $hiddenValues = [];

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
     * @param array $withinDataArray
     * @return array
     */
    public function resultHandle($queryResult){
        $tempArray = [];
        foreach($queryResult as $row){
            $instance = new static;
            foreach($row as $key => $value){
                $finalValue = $value;
                //如果有转换字段,则对字段类型进行转换
                if($instance->cast && isset($instance->cast[$key])){
                    $finalValue = $instance->format($value,$instance->cast[$key]);
                }
                if($instance->primaryKey != $key){
                    $instance->origins[] = $key;
                }
                //如果不在隐藏字段中
                if(in_array($key,$instance->hidden)){
                    $instance->hiddenValues[$key] = $finalValue;
                }else{
                    $instance->$key = $finalValue;
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
     * @param $value
     * @param $cast
     * @return mixed
     * @throws ModelFormatException
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
     * @param Model::class $relatedModelClass
     * @param string $foreignKey
     * @param null $localKey
     * @return OneToOne
     */
    function hasOne($relatedModelClass, $foreignKey ,$localKey = null){
        $localKey = $localKey ?: $this->getPrimaryKey();
        return new OneToOne($relatedModelClass,$foreignKey,$localKey);
    }

    /**
     * @param $relatedModelClass
     * @param $foreignKey
     * @param null $localKey
     * @return OneToMany
     */
    function hasMany($relatedModelClass, $foreignKey , $localKey = null){
        $localKey = $localKey ?: $this->getPrimaryKey();
        return new OneToMany($relatedModelClass,$foreignKey,$localKey);
    }

    function __call($name, $arguments)
    {
        throw new ModelNotFoundException('Can not found the attribute or relation model');
    }

    public function __get($name)
    {
        $reflection = new \ReflectionClass(self::class);
        if($reflection->hasProperty($name)){
            return $this->$name;
        }
        if(isset($this->attributes[$name])){
            $replaceKey = $this->attributes[$name];
            return $this->$replaceKey;
        }
        if(isset($this->hiddenValues[$name])){
            return $this->hiddenValues[$name];
        }
        $relation = $this->$name();
        if($relation instanceof Relation){
            $relationQueryHandle = new RelationQueryHandle($relation,$this);
            return $relationQueryHandle->handleRelationResult();
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