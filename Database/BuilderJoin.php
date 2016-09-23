<?php
/**
 * Created by PhpStorm.
 * User: wugang
 * Date: 16/9/23
 * Time: 09:58
 */

namespace RealRap\Database;


class BuilderJoin
{

    public $joinTableName;

    public $joinRelation;

    public $joinType;

    public function __construct($joinTableName, $joinRelation, $joinType)
    {
        $this->joinTableName = $joinTableName;
        $this->joinRelation  = $joinRelation;
        $this->joinType      = $joinType;
    }

}