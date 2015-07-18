<?php defined('SYSPATH') or die('No direct script access.');

class cfm_client_personal_info extends Migration
{
  public function up()
  {
     $this->create_table
     (
       'cfm_client_personal_info',
       array
       (
         'user_id'             => array('integer', 'null' => false),
         'first_name'          => array('string[30]'),
         'last_name'           => array('string[30]'),
         'email_address'       => array('string[30]'),
         'home_phone'          => array('string[20]'),
         'created_at'          => array('datetime', 'null' => false),  
         'updated_at'          => array('datetime', 'null' => false),
       )
     );
     
     $this->add_foreign_key('cfm_client_personal_info', 'user_id', 'cfm_users', 'id');
  }

  public function down()
  {
  }
}