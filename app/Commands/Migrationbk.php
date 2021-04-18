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
		'--column'	  => 'The column name types and sizes (sizes are optional) in quotes when adding or removing a column (dont use with --fields)',
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
//        CLI::prompt('Name the database table you would like to create:');
//        CLI::write('Hello world!.', 'green');
    
//        $this->component = 'Migration';
        $this->component = 'Migrationbk';
        $this->directory = 'Database\Migrations';
        $this->template  = 'migration4_tpl.php';     //bobk - not the config template

        /*
        if (array_key_exists('session', $params) || CLI::getOption('session'))
        {
            $table     = $params['table'] ?? CLI::getOption('table') ?? 'ci_sessions';
            $params[0] = "_create_{$table}_table";
        }
*/
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
        //bobk 
//		$data['clean_name'] = 'mycleanname';
//		$data['name'] = 'create_fredbloggs_table';
		$data['today'] = date('d/m/Y H:i:s');;
		$data['primary_key'] = 'id';

        //end bobk

        $table   = $this->getOption('table');
		$DBGroup = $this->getOption('dbgroup');
		$return  = $this->getOption('return');
        //bobk
//        $fields =  $this->getOption('fields');
//        $fieldstr = 'id:id name:varchar:26 created:datetime';
//        $arrayFields = $this->parseFields($fields);		// from sprint
//        $str = $this->stringify( $arrayFields );		// from sprint
//        $data['fields'] = trim( $str, ", \n");

		$baseClass = strtolower(str_replace(trim(implode('\\', array_slice(explode('\\', $class), 0, -1)), '\\') . '\\', '', $class));
		$baseClass = strpos($baseClass, 'model') ? str_replace('model', '', $baseClass) : $baseClass;

		$table   = is_string($table) ? $table : plural($baseClass);
		$DBGroup = is_string($DBGroup) ? $DBGroup : 'default';
		$return  = is_string($return) ? $return : 'array';

		$action = $this->getOption('action');
		$data['table'] = $table;

		// prepare for create action
		if ($action === 'create') {
			$fields = $this->getOption('fields');
			if ($fields === null) {
				throw new Exception("error, missing --fields information");
			}
			$arrayFields = $this->parseFields($fields);		// from sprint
			$data['fields'] = trim( $this->stringify( $arrayFields ), ", \n");	//bobk added \n			
		}

		// prepare  for the add action
		if ($action === 'add') {
			$column = $this->getOption('column');
			if ($column === null) {
				throw new Exception("error, missing --column information");			
			}
			$data['columnName'] = substr($column, 0, strpos($column, ':'));
			$columnField = $this->parseFields($column);		// from sprint
			$data['column'] = trim( $this->stringify( $columnField ), ", \n");	//bobk added \n					
		}

		$data['action'] = $action;

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
