<?php

$up     = '';
$down   = '';

//--------------------------------------------------------------------
// Actions
//--------------------------------------------------------------------

/*
 * Create
 */
if ($action == 'create')
{
    $up = "\$fields = {$fields};

        \$this->forge->addField(\$fields);
";


    if (! empty($primary_key))
    {
        $up .= "        \$this->forge->addKey('{$primary_key}', true);
";
    }

    $up .="	    \$this->forge->createTable('{$table}');
    ";

    $down = "\$this->forge->dropTable('{$table}');";
}

/*
 * Add
 */

 if ($action == 'add' && ! empty($column))
{
//    $up = "\$field = [
//    		$column => 
//    			{$column_string}
//    	];
    $up = "\$field = {$column};
    \$this->forge->addColumn('{$table}', \$field);";
					
    $down = "\$this->forge->dropColumn('{$table}', '{$columnName}');";
}


/*
 * Remove
 */

 if ($action == 'remove' && ! empty($column))
{
    $up = "\$this->forge->dropColumn('{$table}', '{$columnName}');";

    $down = "\$field = {$column};
    \$this->forge->addColumn('{$table}', \$field);";
}

//---------------------------------------------------------------------
// The Template
//---------------------------------------------------------------------

echo "<@php

namespace {namespace};

use CodeIgniter\Database\Migration;

/**
 * Migration: {class}
 *
 * Created by: make:migrationplus 
 * code based heavilly on CodeIginter 3 SprintPHP
 * Created on: {$today}
 *
 */
class {class} extends Migration {

    public function up ()
    {
        {$up}
    }

    //--------------------------------------------------------------------

    public function down ()
    {
        {$down}
    }

    //--------------------------------------------------------------------

}";
