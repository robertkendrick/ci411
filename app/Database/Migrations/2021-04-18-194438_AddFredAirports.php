<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: AddFredAirports
 *
 * Created by: SprintPHP
 * Created on: 18/04/2021 20:44:38
 *
 */
class AddFredAirports extends Migration {

    public function up ()
    {
        $field = [
		'tax' => [
			'type' => 'int',
			'constraint' => 9,
			'default' => 0,
		], 
	];
    $this->forge->addColumn('airports', $field);
    }

    //--------------------------------------------------------------------

    public function down ()
    {
        $this->forge->dropColumn('airports', 'tax');
    }

    //--------------------------------------------------------------------

}