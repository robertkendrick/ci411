<?php

use Myth\Models\CIDbModel;

/**
 * Cow_model
 *
 * Auto-generated by Sprint on 2020-11-21 10:33am
 */
class Cow_model extends CIDbModel {

    protected $table_name      = 'cows';
    protected $primary_key     = 'id';

    /* Auto-Date support */
    protected $set_created     = true;
    protected $set_modified    = false;
    protected $created_field   = 'created_on';
    protected $modified_field  = 'modified_on';
    protected $date_format     = 'datetime';

    /* Soft Deletes */
    protected $soft_deletes    = true;
    protected $soft_delete_key = 'deleted';

    /* User Logging */
    protected $log_user            = FALSE;
    protected $created_by_field    = 'created_by';
    protected $modified_by_field   = 'modified_by';
    protected $deleted_by_field    = 'deleted_by';


    /**
     * Various callbacks available to the class. They are simple lists of
     * method names (methods will be ran on $this).
     */
    protected $before_insert   = array();
    protected $after_insert    = array();
    protected $before_update   = array();
    protected $after_update    = array();
    protected $before_find     = array();
    protected $after_find      = array();
    protected $before_delete   = array();
    protected $after_delete    = array();

    /**
     * Protected, non-modifiable attributes
     */
    protected $protected_attributes = ['id'];

    /**
     * By default, we return items as objects. You can change this for the
     * entire class by setting this value to 'array' instead of 'object'.
     * Alternatively, you can do it on a per-instance basis using the
     * 'as_array()' and 'as_object()' methods.
     */
    protected $return_type = 'object';

    /*
        If TRUE, inserts will return the last_insert_id. However,
        this can potentially slow down large imports drastically
        so you can turn it off with the return_insert_id(false) method.
     */
    protected $return_insert_id = true;

    /**
     * @var Array List of fields in the table.
     *
     * This can be set to avoid a database call if using $this->prep_data()
     * and/or $this->get_field_info().
     *
     * Should be in the format: ['field1', 'field2', ...]
     */
    protected $fields = [];

    /**
     * An array of validation rules. This needs to be the same format
     * as validation rules passed to the Form_validation library.
     */
    protected $validation_rules = [
		[
			'field' => 'id',
			'label' => 'Id',
			'rules' => 'integer|max_length[9]',
		],		[
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'alpha_numeric_spaces|max_length[50]',
		],		[
			'field' => 'descr',
			'label' => 'Descr',
			'rules' => 'alpha_numeric_spaces',
		],		[
			'field' => 'deleted',
			'label' => 'Deleted',
			'rules' => 'integer|max_length[1]',
		],		[
			'field' => 'created_on',
			'label' => 'Created On',
			'rules' => '',
		],
];

    /**
     * An array of extra rules to add to validation rules during inserts only.
     * Often used for adding 'required' rules to fields on insert, but not updates.
     *
     *   array( 'username' => 'required|strip_tags' );
     * @var array
     */
    protected $insert_validate_rules = [];

    //--------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
    }

    //--------------------------------------------------------------------

}