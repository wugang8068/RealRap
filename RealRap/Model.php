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
    public $table;
    /**
     * 主键名
     * @var string
     */
    public $primaryKey = 'id';

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
     * @var Formatter
     */
    private $formatter;


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

    public static function findWhere($where){
        $builder = self::all();
        $builder->where($where);
        return $builder;
    }

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
                    if(isset($instance->attributes[$key])){
                        $replaceKey = $instance->attributes[$key];
                        $instance->$replaceKey = $instance->$key;
                        unset($instance->$key);
                    }
                }
            }
            $tempArray[] = $instance;
        }
        return $tempArray;
    }

    private function format($value,$cast){
        if(!$this->formatter){
            $this->formatter = new Formatter();
        }
        return $this->formatter->format($value,$cast);
    }
}