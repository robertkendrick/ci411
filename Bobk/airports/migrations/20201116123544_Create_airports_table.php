<?php

/**
 * Migration: Create Airports Table
 *
 * Created by: SprintPHP
 * Created on: 2020-11-16 12:35pm
 *
 * @property $dbforge
 */
class Migration_create_airports_table extends CI_Migration {

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
			'constraint' => 255,
			'null' => true,
			'default' => '',
		],		'code' => [
			'type' => 'varchar',
			'constraint' => 255,
			'null' => true,
			'default' => '',
		],		'description' => [
			'type' => 'text',
			'null' => true,
		],		'deleted' => [
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0,
		],		'craeted_on' => [
			'type' => 'datetime',
		],	];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', true);
	    $this->dbforge->create_table('airports', true, config_item('migration_create_table_attr') );
    
    }

    //--------------------------------------------------------------------

    public function down ()
    {
        $this->dbforge->drop_table('airports');
    }

    //--------------------------------------------------------------------

}