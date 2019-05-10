# _RealRap_

根据Laravle Eloquent 的 CodeIgenitor 的 ORM 实现.


### 如何安装:

```
composer require csitc/real-rap dev-master

```

### 查询 SELECT

示例: 查询 user , 条件 user\_id &gt;= 50 and order by user\_id and user\_mobile , 并获取第一个

> ```php
>     $users = User::all(['*'])->where([
>         'user_id <=' => 50]
>     )->order([
>         'user_id' => 'desc',
>         'user_mobile' => 'desc'])
>     ->limit(1)->getOne();
> ```

结果如下:

```
{
    "id":50,
    "user_nick_name":"18386053521",
    "user_device_id":"B86E62AC-5FC4-45E3-A3F0-EB4544DB135D",
    "user_mobile":"17288",
    "user_create_date":"2016-07-10 09:44:54"
}
```

在文件 User.php 中, 大概像这样子:

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

### Update 更新操作

> ```php
> $user = User::findWhere([
>     'user_mobile' => '12381121695'
> ])->getOne();
> if($user){
>     $user->user_mobile = '134234';
>     $user->save();
> }
> ```

### Create 创建操作

> ```
> $user = new User();
> $user->user_nick_name = 'Tom';
> $user->save();
> ```

### Delete 删除操作

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

### Transaction 事务处理

> ```php
> \RealRap\RealRap::trans(function(){
>     $user = new User();
>     $user->user_mobile = '13345727773';
>     $user->save();
>     $user = new User();
>     $user->user_mobile = '13347818106';
>     $user->save();
> },function(){
>    echo 'success';
> },function(){
>    echo 'error';
> });
> ```


### ** 关联关系 **

如果想添加模型之间的关联关系, 比如表 inf_user 和 inf_cd_keys. 他们之间有一对多的关联关系, 我们可以这样写:

```
$this->user = User::all(['*'])->where([
            'user_mobile' => '17010058640'
        ])->order([
            'user_id' => 'desc',
            'user_mobile' => 'desc'
        ])->limit(1)->getOne();
```
获取这个用户的keys:

```
$keys = $this->user->key  

```

User.php 大概写法如下:

```
User.php

class User extends Model
{    

	protected $table = 'inf_user';

	protected $primaryKey = 'user_id';
    
	protected function key(){
        return $this->hasMany(Key::class,'cdk_bind_user');
        //return $this->hasOne(Key::class,'cdk_bind_user');
    }
}

Key.php

class Key extends Model
{

    protected $table = 'inf_cd_keys';

    protected $primaryKey = 'cdk_id';

}

```

To DO LIST:

* Wrap the collection data instead of an array


