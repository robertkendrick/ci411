<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: CreateAddresses
 *
 * Created by: SprintPHP
 * Created on: 18/04/2021 20:46:40
 *
 */
class CreateAddresses extends Migration {

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
			'constraint' => 26,
			'null' => true,
			'default' => '',
		], 
		'address' => [
			'type' => 'varchar',
			'constraint' => 250,
			'null' => true,
			'default' => '',
		], 
		'created' => [
			'type' => 'datetime',
			'null' => true,
		], 
	];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
	    $this->forge->createTable('createaddresses');
    
    }

    //--------------------------------------------------------------------

    public function down ()
    {
        $this->forge->dropTable('createaddresses');
    }

    //--------------------------------------------------------------------

}