<?php defined('SYSPATH') or die('No direct script access.');

class cfm_user_tokens extends Migration
{
  public function up()
  {
     $this->create_table
     (
       'cfm_user_tokens',
       array
       (
           'user_id'           => array('integer', 'null' => false),
           'user_agent'        => array('string[50]'),
           'token'             => array('string[50]'),
           'created'           => array('integer'),
           'expires'           => array('integer'),
       )
     );
     
     $this->add_foreign_key('cfm_user_tokens', 'user_id', 'cfm_users', 'id');
  }

  public function down()
  {

  }
}