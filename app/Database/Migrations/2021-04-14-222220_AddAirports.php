<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: AddAirports
 *
 * Created by: SprintPHP
 * Created on: 14/04/2021 23:22:22
 *
 */
class AddAirports extends Migration {

    public function up ()
    {
        $field = [
		'mycol' => [
			'type' => 'varchar',
			'constraint' => 10,
			'null' => true,
			'default' => '',
		], 
	];
    $this->forge->addColumn('airports', $field);
    }

    //--------------------------------------------------------------------

    public function down ()
    {
        $this->forge->dropColumn('airports', '
');
    }

    //--------------------------------------------------------------------

}