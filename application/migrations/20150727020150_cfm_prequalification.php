<?php defined('SYSPATH') or die('No direct script access.');

class cfm_prequalification extends Migration
{
  public function up()
  {
     $this->create_table
     (
       'cfm_pre_qualification',
       array
       (
         'user_id'             => array('integer', 'null' => false),
         'mortgage_balance'    => array('decimal[15,2]'),
         'short_term_debts'    => array('integer'),
         'market_value'        => array('decimal[15,2]'),
         'created_at'          => array('datetime', 'null' => false),  
         'updated_at'          => array('datetime', 'null' => false),
       )
     );
     
     $this->add_foreign_key('cfm_pre_qualification', 'user_id', 'cfm_users', 'id');
  }

}