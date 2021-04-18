<?php
//namespace someone\plugin\Commands;
namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class PrintHelloWorld extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
//    protected $group = 'Testing';
    protected $group = 'Testing';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'print:dummy';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Print Hello World';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'print:dummy [options]';

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
    protected $options = [];

    /**
     * Actually execute the command.
     *
     * @param array $params
     *
     * @return void
     */
    public function run(array $params)
    {
        CLI::write('Hello world!.', 'green');
    }
} 
