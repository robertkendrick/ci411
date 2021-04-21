<?php
namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\GeneratorTrait;

class Migrationbk extends BaseCommand
{
    use GeneratorTrait;
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Testing';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'make:migrationbk';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Make a migration file to create a table';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'make:migrationbk [options]';

    /**
     * The path to someone\src directory.
     *
     * @var string
     */
    protected $sourcePath;

    /**
     * The command's options
     *
     * @var array
     */
	protected $options = [
		'--namespace' => 'Set root namespace. Default: "APP_NAMESPACE".',
		'--dbgroup'   => 'Database group to use. Default: "default".',
		'--action'	  => 'What action to perform (create, add or remove)',
		'--table'     => 'Supply a table name.',
        '--fields'    => 'The column names, types and sizes (sizes are optional) in quotes when creating a table. Eg. "id:id name:varchar:25"',
		'--column'	  => 'The column name, type and size (size is optional) in quotes when adding or removing a column (dont use with --fields)',
    ];

    /**
     * Actually execute the command.
     *
     * @param array $params
     *
     * @return void
     */
    public function run(array $params)
    {
        $this->component = 'Migrationbk';
        $this->directory = 'Database\Migrations';
        $this->template  = 'migration4_tpl.php';     //bobk - not the config template

		if (array_key_exists('session', $params) || CLI::getOption('session'))
		{
			$this->template = 'migration.tpl.php';
			$table     = $params['table'] ?? CLI::getOption('table') ?? 'ci_sessions';
			$params[0] = "_create_{$table}_table";
		}

        $this->execute($params);
    }

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

			return $this->parseTemplate($class, [], [], $data);
		}
		else {
			//bobk: prompting
			$action = $this->getOption('action') ??
				$action = CLI::prompt(
					'What migration action are you performing? (create, add or remove)?', null, 'required');
			
			$table = $this->getOption('table') ??
				$table = CLI::prompt('Name the database table?', null, 'required');

			if ($action === 'create') {
				$fields = $this->getOption('fields') ??
					$fields = CLI::prompt(
						'Enter the column names, types and sizes (sizes optional) Eg. id:id name:varchar:25 created:datetime', 
						null, 'required');
				$arrayFields = $this->parseFields($fields);		// from sprint
				$data['fields'] = trim( $this->stringify( $arrayFields ), ", \n");	//bobk added \n			
			} else {
				if ($action === 'add' || $action === 'remove') {
					$column = $this->getOption('column') ??
						$column = CLI::prompt(
							'Enter the column name, type and size (size is optional) that you are adding or removing Eg. name:varchar:25', 
							null, 'required');
					$data['columnName'] = substr($column, 0, strpos($column, ':'));
					$columnField = $this->parseFields($column);		// from sprint
					$data['column'] = trim( $this->stringify( $columnField ), ", \n");	//bobk added \n					
				}
			}
	//        CLI::write('Hello world!.', 'green');
	//------------------------------------------------------------------------------------
			$data['today'] = date('d/m/Y H:i:s');;
			$data['primary_key'] = 'id';

			$DBGroup = $this->getOption('dbgroup');
			$return  = $this->getOption('return');

			$baseClass = strtolower(str_replace(trim(implode('\\', array_slice(explode('\\', $class), 0, -1)), '\\') . '\\', '', $class));
			$baseClass = strpos($baseClass, 'model') ? str_replace('model', '', $baseClass) : $baseClass;

			$table   = is_string($table) ? $table : plural($baseClass);
			$DBGroup = is_string($DBGroup) ? $DBGroup : 'default';
			$return  = is_string($return) ? $return : 'array';

			$data['table'] = $table;
			$data['action'] = $action;
		}
		
		return $this->parseTemplate($class, ['{table}', '{DBGroup}', '{return}'], 
                                        [$table, $DBGroup, $return], $data);
    }

	//------------------------------------------------------------------------------
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

//----------------------------------------------------------------------------------
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
	 * fields ready for forge;
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
		'datetime'	=> true,
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
} 
