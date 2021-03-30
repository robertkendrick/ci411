<?php

/**
 * Migration: Create Cows Table
 *
 * Created by: SprintPHP
 * Created on: 2020-11-19 20:20pm
 *
 * @property $dbforge
 */
class Migration_create_cows_table extends CI_Migration {

    public function up ()
    {
        $fields = [
		'id' => [
			'type' => 'int',
			'unsigned' => true,
			'auto_increment' => true,
			'constraint' => 9,
		],		'name' => [
			'type' => 'varchar',
			'constraint' => 50,
			'null' => true,
			'default' => '',
		],		'descr' => [
			'type' => 'text',
			'null' => true,
		],		'deleted' => [
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0,
		],		'created_on' => [
			'type' => 'datetime',
		],	];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', true);
	    $this->dbforge->create_table('cows', true, config_item('migration_create_table_attr') );
    
    }

    //--------------------------------------------------------------------

    public function down ()
    {
        $this->dbforge->drop_table('cows');
    }

    //--------------------------------------------------------------------

}