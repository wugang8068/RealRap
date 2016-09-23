<?php

namespace App\models;
use RealRap\Model\Model as Model;

/**
 * Class User
 *
 * @package App\Models\PostLoanModel
 * @property integer $user_id
 * @property string $user_nick_name
 * @property string $user_device_id
 * @property string $user_mobile
 * @property string $user_password
 * @property string $user_create_date
 * @mixin User
 */
class User extends Model
{

    protected $table = 'inf_user';

    protected $primaryKey = 'user_id';

    protected $cast = [
        'user_id' => 'integer',
        'is_subscribed' => 'bool'
    ];

    protected $hidden = [
        'agent_user',
        'bank_real_name',
        'is_subscribed',
        'rebate_already_mentioned',
        'rebate_being_mention',
        'rebate_unmentioned',
        'user_email'
    ];

    protected $attributes = [
        'user_id' => 'id',
    ];

    public function key(){
        return $this->hasMany(Key::class,'cdk_bind_user');
        //return $this->hasOne(Key::class,'cdk_bind_user');
    }

    public function order(){
        return $this->hasOne(Order::class,'related_user');
    }
}