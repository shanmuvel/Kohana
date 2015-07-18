<?php defined('SYSPATH') or die('No direct script access.');

class cfm_user_info extends Migration
{
  public function up()
  {
     $this->create_table
     (
       'cfm_user_info',
       array
       (
         'user_id'             => array('integer', 'null' => false),
         'first_name'          => array('string[30]'),
         'last_name'           => array('string[30]'),
         'profile_image'       => array('string[60]'),
         'company_name'        => array('string[30]'),
         'telephone_number'    => array('string[20]'),
         'address_line1'       => array('text'),
         'address_line2'       => array('text'),  
         'created_at'          => array('datetime', 'null' => false),  
         'updated_at'          => array('datetime', 'null' => false),
       )
     );
     
     $this->add_foreign_key('cfm_user_info', 'user_id', 'cfm_users', 'id');
  }

  public function down()
  {
  }
}