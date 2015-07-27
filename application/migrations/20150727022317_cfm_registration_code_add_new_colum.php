<?php defined('SYSPATH') or die('No direct script access.');

class cfm_registration_code_add_new_colum extends Migration
{
  public function up()
  {
    $this->add_column('cfm_user_registration_code', 'is_verified', array('boolean'));
  }

  public function down()
  {
    // $this->drop_table('table_name');

    // $this->remove_column('table_name', 'column_name');
  }
}