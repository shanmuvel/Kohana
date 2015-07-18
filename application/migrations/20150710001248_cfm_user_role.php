<?php defined('SYSPATH') or die('No direct script access.');

class cfm_user_role extends Migration
{
  public function up()
  {
     $this->create_table
     (
       'cfm_user_roles',
       array
       (
         'name'                => array('string[30]'),
         'description'         => array('text'),
       )
     );
  }

  public function down()
  {
  }
}