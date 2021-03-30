<?php

/**
 * Migration: Add Two Tone Column To Cows Table
 *
 * Created by: SprintPHP
 * Created on: 2020-12-01 20:04pm
 *
 * @property $dbforge
 */
class Migration_add_two_tone_column_to_cows_table extends CI_Migration {

    public function up ()
    {
        $field = [
    		two_tone => 
    			[
		'type' => 'varchar',
		'constraint' => 32,
		'null' => true,
		'default' => '',
	]
    	];
        $this->dbforge->add_column('cows', $field);
    }

    //--------------------------------------------------------------------

    public function down ()
    {
        $this->dbforge->drop_column('cows', 'two_tone');
    }

    //--------------------------------------------------------------------

}