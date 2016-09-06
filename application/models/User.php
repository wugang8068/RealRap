<?php

namespace App\models;
use RealRap\Model;

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

    public $table = 'inf_user';

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
}