<?php

namespace App\Controllers;

use \Bobk\airports\controllers\Airports;

class BkTest extends BaseController
{
	public function index()
	{
		echo 'bktest::index()';
		//return view('welcome_message');
	}

	public function otherController()
	{
		// calling another controller in App namespace
		$h = new Home();
		return $h->index();
	}

	public function otherModule()
	{
	//	$m = new \Bobk\airports\controllers\Airports();
		$m = new Airports();
		return $m->index();
	}

	public function dbtest()
	{
		$model = model('Bktest_model');
		
//		$builder = $model->builder();
//		$builder->select('name, code');
		
//		$model->builder()	//don't work - not same as above
//			->select('name', 'code');

//		$result = $model->findAll();
		$result = $model->select('name, code')->findAll(); 

		var_dump($result);		
	
	}

	public function testPage()
	{
		return view('test_page');
	}
}
