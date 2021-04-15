<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Bkuser
 *
 * Created by: SprintPHP
 * Created on: 13/04/2021 22:49:23
 *
 */
class Bkuser extends Migration {

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
	    $this->forge->createTable('bkusers');
    
    }

    //--------------------------------------------------------------------

    public function down ()
    {
        $this->forge->dropTable('bkusers');
    }

    //--------------------------------------------------------------------

}