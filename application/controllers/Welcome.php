<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use App\models\User;

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		header('Content-Type:application/json');
		$users = User::all(['*'])->where([
				'user_id <=' => 50
		])->order([
				'user_id' => 'desc',
				'user_mobile' => 'desc'
		])->limit(1)->getOne();
		//$users->user_mobile = '17288';
		//print_r($users->save());
		print_r(json_encode($users));
	}
}
