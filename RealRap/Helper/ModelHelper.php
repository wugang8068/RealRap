<?php
/**
 * Created by PhpStorm.
 * User: wugang
 * Date: 16/9/7
 * Time: 09:36
 */

namespace RealRap\Helper;


class ModelHelper
{

    /**
     * @var
     */
    private $modelClass;

    /**
     * @var \ReflectionClass
     */
    private $reflection;

    /**
     * ModelHelper constructor.
     * @param $modelClass
     */
    public function __construct($modelClass)
    {
        $this->modelClass = $modelClass;
        $this->reflection = new \ReflectionClass($this->modelClass);
    }

    /**
     *
     */
    public function getPublicAttributes(){
        return array_map(function($element){
            return $element->name;
        },array_filter($this->reflection->getProperties(),function($element){
            return $element->isPublic();
        }));
    }

    public function getProtectedAttributes(){

    }
}