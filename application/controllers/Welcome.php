<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use App\models\User;

class Welcome extends CI_Controller {

	public function update()
	{
		$user = User::findWhere(['user_mobile' => '12381121695'])->getOne();
		if($user){
			$user->user_mobile = '134234';
			$user->save();
			print_r($user);
		}
	}

	public function insert(){
		$user = new User();
		$user->user_nick_name = 'This is a just test nick name';
		$user->save();
	}

	public function retrieve(){
        $users = User::all(['*'])->where([
            'user_id <=' => 50
        ])->order([
            'user_id' => 'desc',
            'user_mobile' => 'desc'
        ])->limit(1)->getOne();
        print_r(json_encode($users));
	}

    public function transaction(){
        \RealRap\RealRap::trans(function(){


            $user = new User();
            $user->user_mobile = '13345727773';
            $user->save();

            $user = new User();
            $user->user_mobile = '13347808105';
            $user->save();
        },function(){
            echo 'success Retrieve';
        },function(){
            echo 'error Retrieve';
        });
    }

    public function delete(){
        $user = User::findWhere(['user_mobile' => '18600908262'])->getOne();
        if($user){
            print_r($user->delete() ? 'record delete success' : 'record delete failed');
        }else{
            print_r('record is not exists');
        }

        //or
        //print_r(User::findWhere(['user_mobile' => '18600908262'])->delete() ? 'record delete success' : 'record delete failed');
    }
}
