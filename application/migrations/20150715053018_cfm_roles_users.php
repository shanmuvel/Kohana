<?php defined('SYSPATH') or die('No direct script access.');

class cfm_roles_users extends Migration
{
  public function up()
  {
     $this->create_table
     (
       'cfm_roles_users',
       array
       (
         'user_id'              => array('integer', 'null' => false),
         'role_id'              => array('integer', 'null' => false),  
       )
     );
     
     $this->add_foreign_key('cfm_roles_users', 'user_id', 'cfm_users', 'id');
     $this->add_foreign_key('cfm_roles_users', 'role_id', 'cfm_user_roles', 'id');
  }

  public function down()
  {
  }
}