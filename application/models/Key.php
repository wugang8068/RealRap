<?php
/**
 * Created by PhpStorm.
 * User: wugang
 * Date: 16/9/23
 * Time: 09:08
 */

namespace App\models;

use RealRap\Model\Model as Model;


class Key extends Model
{

    protected $table = 'inf_cd_keys';

    protected $primaryKey = 'cdk_id';

    protected $hidden = [
        'cdk_belong_agent',
        'cdk_bind_user',
        'cdk_expire_time',
        'has_been_sold',
        'comments',
        'is_deleted'
    ];
}