<?php defined('SYSPATH') or die('No direct script access.');

class cfm_sessions extends Migration
{
  public function up()
  {
     $this->create_table
     (
       'cfm_sessions',
       array
       (
         'session_id'          => array('string[25]'),
         'last_active'         => array('integer'),
         'contents'            => array('text'),
       )
     );
  }

  public function down()
  {
  }
}