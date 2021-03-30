<?php

/**
 * Migration: Add Rental Column To Cows Table
 *
 * Created by: SprintPHP
 * Created on: 2020-11-21 18:59pm
 *
 * @property $dbforge
 */
class Migration_add_rental_column_to_cows_table extends CI_Migration {

    public function up ()
    {
        $field = [
			'rental' =>
			[
				'type' => 'text',
				'null' => true,
			]
		];
        $this->dbforge->add_column('cows', $field);
    }

    //--------------------------------------------------------------------

    public function down ()
    {
        $this->dbforge->drop_column('cows', 'rental');
    }

    //--------------------------------------------------------------------

}