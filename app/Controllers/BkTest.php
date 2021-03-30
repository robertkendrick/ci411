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
}
