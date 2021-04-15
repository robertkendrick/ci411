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
		
		$builder = $model->builder();
		$builder->select('name, code');

		$result = $model->findAll();
		var_dump($result);		
	
		//$result = $model->select('name, code')->findAll(); 
	}

	public function migrationTest()
	{
/*
		$arrayFields = [
			'id' => [
				'type' => 'int',
				'unsigned' => true,
				'auto_increment' => true,
				'constraint' => 9,
			],		
			'name' => [
				'type' => 'varchar',
				'constraint' => 40,
				'null' => true,
				'default' => '',
			],		
			'created' => [
				'type' => 'datetime',
			],	
		];
*/
		$fieldstr = 'id:id name:varchar:26 created:datetime';
		$arrayFields = $this->parseFields($fieldstr);

		$fullPath = 'C:\Users\bob\Documents\PHP_WebSites\codeigniter\ci411\app\Views\migration4_tpl.php';
		$migFilename = $this->basename($fullPath);

		$data['clean_name'] = 'mycleanname';
		$data['name'] = 'create_fredbloggs_table';
		$data['today'] = '9 April 2021';
		$data['table'] = 'fredbloggs';
		$data['action'] = 'create';
		$data['primary_key'] = 'id';
		$data['fields'] = trim( $this->stringify( $arrayFields ), ", \n");	//bobk added \n

//		$op = view('migration', $data);
		dd( view('migration4_tpl', $data) );
	}

	// from Sprint Myth\Forge\BasGenerator
	// Coverts an array into a string
	protected function stringify($array, $depth=0)
	{
		if (! is_array($array))
		{
			return '';
		}

		$str = '';

		if ($depth > 1)
		{
			$str .= str_repeat("\t", $depth);
		}

		$depth++;

		$str .= "[\n";

		foreach ($array as $key => $value)
		{
			$str .= str_repeat("\t", $depth +1);

			if (! is_numeric($key))
			{
				$str .= "'{$key}' => ";
			}

			if (is_array($value))
			{
				$str .= $this->stringify($value, $depth);
			}
			else if (is_bool($value))
			{
				$b = $value === true ? 'true' : 'false';
				$str .= "{$b},\n";
			}
			else if (is_numeric($value))
			{
				$str .= "{$value},\n";
			}
			else
			{
				$str .= "'{$value}',\n";
			}
		}

		$str .= str_repeat("\t", $depth) ."], \n";	//bobk: added \n

		return $str;
	}

	//--------------------------------------------------------------------
	// from Sprint Myth\_generators\MigrationGenerator
	/**
	 * Parses a string containing 'name:type' segments into an array of
	 * fields ready for $dbforge;
	 *
	 * @param $str
	 *
	 * @return array
	 */
	public function parseFields($str)
	{
        if (empty($str))
        {
	        return;
        }

		$fields = [];
		$segments = explode(' ', $str);

		if (! count($segments))
		{
			return $fields;
		}

		foreach ($segments as $segment)
		{
			$pop = [null, null, null];
			list($field, $type, $size) = array_merge( explode(':', $segment), $pop);
			$type = strtolower($type);

			// Is type one of our convenience mapped items?
			if (array_key_exists($type, $this->map))
			{
				$type = $this->map[$type];
			}

			$f = [ 'type' => $type ];

			// Creating a primary key?
			if ($type == 'id')
			{
				$f['type'] = 'int';
				$size = empty($size) ? 9 : $size;
				$f['unsigned'] = true;
				$f['auto_increment'] = true;

				$this->primary_key = $field;
			}

			// Constraint?
			if (! empty($size))
			{
				$f['constraint'] = (int)$size;
			}
			else if (array_key_exists($type, $this->defaultSizes))
			{
				$f['constraint'] = $this->defaultSizes[$type];
			}

			// NULL?
			if (array_key_exists($type, $this->defaultNulls))
			{
				$f['null'] = true;
			}

			// Default Value?
			if (array_key_exists($type, $this->defaultValues))
			{
				$f['default'] = $this->defaultValues[$type];
			}

			$fields[$field] = $f;
		}

//		var_dump($fields);
		
		return $fields;
	}

	//-------------------------------------------------------------------
	// from Sprint Myth\_generators\MigrationGenerator

	protected $defaultSizes = [
		'tinyint'   => 1,
		'int'       => 9,
		'bigint'    => 20,
		'char'      => 20,
		'varchar'   => 255,
	];

	protected $defaultValues = [
		'tinyint'   => 0,
		'mediumint' => 0,
		'int'       => 0,
		'bigint'    => 0,
		'float'     => 0.0,
		'double'    => 0.0,
		'char'      => NULL,
		'varchar'   => NULL,
	];

	protected $defaultNulls = [
		'char'      => true,
		'varchar'   => true,
		'text'      => true,
	];

	protected $map = [
		'string'    => 'varchar',
		'number'    => 'int'
	];

	protected $allowedActions = [
		'create', 'add', 'remove'
	];

	protected $actionMap = [
		'make'      => 'create',
		'insert'    => 'add',
		'drop'      => 'remove',
		'delete'    => 'remove'
	];

	protected $segments = [];	// The migration command line split on '_' into its seperate words

	
	// from CodeOgniter 4.1.1 MigrationGenerator	
	/**
	 * Change file basename before saving.
	 *
	 * @param string $filename
	 *
	 * @return string
	 */
	protected function basename(string $filename): string
	{
		return gmdate(config('Migrations')->timestampFormat) . basename($filename);
	}

}
