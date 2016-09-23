<?php
/**
 * Created by PhpStorm.
 * User: wugang
 * Date: 16/9/23
 * Time: 10:51
 */

namespace RealRap\Relation;

class OneToMany implements  Relation
{

    private $foreignKey;
    private $localKey;
    private $relatedModelClass;

    public function __construct($relatedModelClass,$foreignKey,$localKey)
    {
        $this->relatedModelClass = $relatedModelClass;
        $this->foreignKey = $foreignKey;
        $this->localKey = $localKey;
    }

    public function getRelatedModelClass()
    {
        return $this->relatedModelClass;
    }

    public function getLocalKey(){
        return $this->localKey;
    }

    public function getForeignKey(){
        return $this->foreignKey;
    }
}