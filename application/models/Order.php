<?php
/**
 * Created by PhpStorm.
 * User: wugang
 * Date: 16/9/23
 * Time: 17:21
 */

namespace App\models;


use RealRap\Model\Model;

class Order extends Model
{

    protected $table = 'wx_inf_order';

    protected $primaryKey = 'index_id';

}