<?php defined('SYSPATH') or die('No direct script access.');

class cfm_user_registration_code extends Migration
{
  public function up()
  {
     $this->create_table
     (
       'cfm_user_registration_code',
       array
       (
         'user_id'                 => array('integer', 'null' => false),
         'registration_code'       => array('string[10]'),
       )
     );
     
     $this->add_foreign_key('cfm_user_registration_code', 'user_id', 'cfm_users', 'id');
  }

  public function down()
  {
  
  }
}