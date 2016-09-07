# _RealRap_

This is a CI ORM, and inspired by laravel eloquent

### Retrieve

Example: We need to fetch the user where user\_id &gt;= 50 and order by user\_id and user\_mobile and get the first one

> ```php
>     $users = User::all(['*'])->where([
>         'user_id <=' => 50]
>     )->order([
>         'user_id' => 'desc',
>         'user_mobile' => 'desc'])
>     ->limit(1)->getOne();
> ```

The result mybe like this:

```
{
    "id":50,
    "user_nick_name":"18386053521",
    "user_device_id":"B86E62AC-5FC4-45E3-A3F0-EB4544DB135D",
    "user_mobile":"17288",
    "user_create_date":"2016-07-10 09:44:54"
}
```

In the User.php, we can just write like this:

> ```
> class User extends Model{
>
>     protected $table = 'inf_user';
>
>     protected $primaryKey = 'user_id';
>
>     protected $cast = [
>         'user_id' => 'integer',
>         'is_subscribed' => 'bool'
>     ];
>
>     protected $hidden = [
>         'agent_user',
>         'bank_real_name',
>         'is_subscribed',
>         'rebate_already_mentioned',
>         'rebate_being_mention',
>         'rebate_unmentioned',
>         'user_email'
>     ];
>
>     protected $attributes = [
>         'user_id' => 'id',
>     ];
>
> }
> ```
