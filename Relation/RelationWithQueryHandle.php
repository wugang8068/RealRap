<?php
/**
 * Created by PhpStorm.
 * User: wugang
 * Date: 16/9/23
 * Time: 16:15
 */

namespace RealRap\Relation;


use RealRap\Database\Builder;
use RealRap\Model\Model;

class RelationWithQueryHandle
{


    /**
     * related values which can search in database
     * @var array
     */
    private $relatedValues;

    /**
     * @var Model
     */
    private $model;

    /**
     * @var Relation
     */
    private $relation;

    public function __construct(Relation $relation, Model $model,$relatedValues)
    {
        $this->relatedValues = $relatedValues;
        $this->model = &$model;
        $this->relation = $relation;
    }

    /**
     * @return mixed
     */
    public function handleRelationResult(){
        $builder = $this->setUpBuilder();
        return $builder->get();
    }

    /**
     * @return Builder
     */
    private function setUpBuilder(){
        $builderModel = $this->getRelationModel();
        $builder = new Builder($builderModel);
        $builder->setModel($builderModel);
        $builder->whereIn($this->getRelationForeignKey(),$this->relatedValues);
        return $builder;
    }

    /**
     * @return mixed
     */
    private function getRelationModel(){
        $relatedModelName =  $this->relation->getRelatedModelClass();
        return new $relatedModelName();
    }

    /**
     * @return string
     */
    private function getRelationForeignKey(){
        return $this->relation->getForeignKey();
    }

}