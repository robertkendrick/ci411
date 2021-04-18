<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: AddTaxAirports
 *
 * Created by: SprintPHP
 * Created on: 15/04/2021 14:14:54
 *
 */
class AddTaxAirports extends Migration {

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