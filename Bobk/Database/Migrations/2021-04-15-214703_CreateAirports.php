<?php

namespace Bobk\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: CreateAirports
 *
 * Created by: SprintPHP
 * Created on: 15/04/2021 22:47:03
 *
 */
class CreateAirports extends Migration {

    public function up ()
    {
        $fields = [
		'id' => [
			'type' => 'int',
			'unsigned' => true,
			'auto_increment' => true,
			'constraint' => 9,
		], 
		'name' => [
			'type' => 'varchar',
			'constraint' => 79,
			'null' => true,
			'default' => '',
		], 
		'code' => [
			'type' => 'varchar',
			'constraint' => 4,
			'null' => true,
			'default' => '',
		], 
		'description' => [
			'type' => 'varchar',
			'constraint' => 255,
			'null' => true,
			'default' => '',
		], 
	];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
	    $this->forge->createTable('airports');
    
    }

    //--------------------------------------------------------------------

    public function down ()
    {
        $this->forge->dropTable('airports');
    }

    //--------------------------------------------------------------------

}