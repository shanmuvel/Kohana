<?php defined('SYSPATH') or die('No direct script access.');

class cfm_users extends Migration
{
  public function up()
  {
     $this->create_table
     (
       'cfm_users',
       array
       (
         'email'               => array('string[30]'),
         'password'            => array('string[200]'),
         'logins'              => array('integer', 'unsigned' => TRUE, 'default' => 0),
         'last_login'          => array('integer', 'unsigned' => TRUE),
         'is_active'           => array('boolean'),
         'is_remove'           => array('boolean'),  
         'created_at'          => array('datetime', 'null' => false),  
         'updated_at'          => array('datetime', 'null' => false),
       )
     );
  }

  public function down()
  {
   
  }
}