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

> ```php
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

### Update

> ```php
> $user = User::findWhere([
>     'user_mobile' => '12381121695'
> ])->getOne();
> if($user){
>     $user->user_mobile = '134234';
>     $user->save();
> }
> ```

### Insert

> ```
> $user = new User();
> $user->user_nick_name = 'Tom';
> $user->save();
> ```

### Delete

> ```
> $user = User::findWhere(['user_mobile' => '18600908262'])->getOne();
> if($user){
>     print_r($user->delete() ? 'record delete success' : 'record delete failed');
> }else{
>     print_r('record is not exists');
> }
> ```

or

> ```php
> User::findWhere(['user_mobile' => '18600908262'])->delete()
> ```

### Transaction

> ```php
> \RealRap\RealRap::trans(function(){
>     $user = new User();
>     $user->user_mobile = '13345727773';
>     $user->save();
>     $user = new User();
>     $user->user_mobile = '13347818106';
>     $user->save();
> },function(){
>    echo 'success Retrieve';
> },function(){
>    echo 'error Retrieve';
> });
> ```

To DO LIST:

* Complete the Update And Delete Insert
* Resolve the Model Relationship
* Resoleve the Transaction, Maybe it has been resolved now, just you can use the CI's transaction
* Complete the collection data, not return an array
