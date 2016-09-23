<?php
/**
 * Created by PhpStorm.
 * User: wugang
 * Date: 16/9/23
 * Time: 09:12
 */

namespace RealRap\Relation;

interface Relation
{


    /**
     * @return string
     */
    public function getRelatedModelClass();

    /**
     * @return string
     */
    public function getLocalKey();

    /**
     * @return string
     */
    public function getForeignKey();
}