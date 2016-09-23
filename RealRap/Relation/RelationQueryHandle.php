<?php
/**
 * Created by PhpStorm.
 * User: wugang
 * Date: 16/9/23
 * Time: 09:37
 */

namespace RealRap\Relation;


use RealRap\Database\Builder;
use RealRap\Model\Model;

class RelationQueryHandle
{


    /**
     * @var Relation
     */
    private $relation;

    /**
     * @var Model
     */
    private $model;


    /**
     * RelationQueryHandle constructor.
     * @param Relation $relation
     * @param Model $model
     */
    public function __construct(Relation $relation, Model $model)
    {
        $this->relation = $relation;
        $this->model    = &$model;
    }

    /**
     * @return mixed
     */
    public function handleRelationResult(){
        if($this->relation instanceof OneToOne){
            return $this->handleOneToOneRelation();
        }
        if($this->relation instanceof OneToMany){
            return $this->handleOneToManyRelation();
        }
        return null;
    }


    /**
     * @return null|Model
     */
    private function handleOneToOneRelation(){
        $builder = $this->setUpBuilder();
        return $builder->getOne();
    }


    /**
     * @return \RealRap\Model\Model[]
     */
    private function handleOneToManyRelation(){
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
        $builder->where([$this->getRelationForeignKey() => $this->getRelationRelatedValue()]);
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

    /**
     * @return mixed|null
     */
    private function getRelationRelatedValue(){
        $modelRelatedKey = $this->relation->getLocalKey();
        return $this->model->$modelRelatedKey;
    }

}