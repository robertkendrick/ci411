<?php

/**
 * This file is part of the CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

//namespace CodeIgniter\Commands\Generators;
namespace someone\plugins\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Someone\plugins\GeneratorTrait;

/**
 * Generates a skeleton migration file.
 */
class MigrationGenerator2 extends BaseCommand
{
	use GeneratorTrait;

	/**
	 * The Command's Group
	 *
	 * @var string
	 */
//	protected $group = 'Generators';
	protected $group = 'Testing';

	/**
	 * The Command's Name
	 *
	 * @var string
	 */
	protected $name = 'make:migration2';

	/**
	 * The Command's Description
	 *
	 * @var string
	 */
	protected $description = 'Generates a new migration file.';

	/**
	 * The Command's Usage
	 *
	 * @var string
	 */
	protected $usage = 'make:migration2 <name> [options]';

	/**
	 * The Command's Arguments
	 *
	 * @var array
	 */
	protected $arguments = [
		'name' => 'The migration class name.',
	];

	/**
	 * The Command's Options
	 *
	 * @var array
	 */
	protected $options = [
		'--session'   => 'Generates the migration file for database sessions.',
		'--table'     => 'Table name to use for database sessions. Default: "ci_sessions".',
		'--dbgroup'   => 'Database group to use for database sessions. Default: "default".',
		'--namespace' => 'Set root namespace. Default: "APP_NAMESPACE".',
		'--suffix'    => 'Append the component title to the class name (e.g. User => UserMigration).',
	];

	/**
	 * Actually execute a command.
	 *
	 * @param array $params
	 */
	public function run(array $params)
	{
		$this->component = 'Migration';
		$this->directory = 'Database\Migrations';
		$this->template  = 'migration.tpl.php';

		if (array_key_exists('session', $params) || CLI::getOption('session'))
		{
			$table     = $params['table'] ?? CLI::getOption('table') ?? 'ci_sessions';
			$params[0] = "_create_{$table}_table";
		}

		//bobk: add
		$args = $params;
		$cmd = array_shift($args);	// get rid of command for now
		$fieldstr = implode(' ', $args);
//		$sd = 'id:id name:string:45 created:datetime';
		$fields = $this->parseFields($fieldstr);
		//end bobk

	 	$this->execute($params);
	}

		// public function run(array $params)
		// {
		// 	CLI::write('Hello world!.', 'yellow');
		// }

	/**
	 * Prepare options and do the necessary replacements.
	 *
	 * @param string $class
	 *
	 * @return string
	 */
	protected function prepare(string $class): string
	{
		$data['session'] = false;

		if ($this->getOption('session'))
		{
			$table   = $this->getOption('table');
			$DBGroup = $this->getOption('dbgroup');

			$data['session'] = true;
			$data['table']   = is_string($table) ? $table : 'ci_sessions';
			$data['DBGroup'] = is_string($DBGroup) ? $DBGroup : 'default';
			$data['matchIP'] = config('App')->sessionMatchIP;
		}

		return $this->parseTemplate($class, [], [], $data);
	}

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

	//bobk: From Sprint
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

	//--------------------------------------------------------------------
	/**
	 * Parses a string containing 'name:type' segments into an array of
	 * fields ready for $dbforge;
	 *
	 * @param $str
	 *
	 * @return array
	 */
	//bobk: From sprint
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
}
